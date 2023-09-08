<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\SuperAdminOwnerChat as SuperAdminOwnerChatModel;
use App\Interfaces\OwnerInterface;
use App\Models\Cart;
use App\Models\Claim;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Reservation;
use App\Models\Notification;
use App\Events\SuperAdminOwnerChat;
class OwnerRepository implements OwnerInterface
{
    public function login($request)
    {
        $user = User::with('restaurants')->where('email', $request->email)->where('user_type', 1)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        } elseif ($user->status === '0') {
            return response([
                'message' => ['Please verify your email address to activate your account.']

            ], 404);
        } elseif ($user->status === '2') {
            return response([
                'message' => ['This account has been blocked. Please contact our support staff.']


            ], 404);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,

            'token' => $token
        ];

        return response($response, 201);
    }
    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'User log out successfully'
        ]);
    }
    public function users($request)
    {
        if ($request->status != 'null') {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return  User::with('restaurants')->where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->orderBy($request->key, $request->order)->paginate($request->paginate ?? 10);
            } else {
                return  User::with('restaurants')->where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->where('status', $request->status)->paginate($request->paginate ?? 10);
            }
        } else {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return  User::with('restaurants')->where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->orderBy($request->key, $request->order)->paginate($request->paginate ?? 10);
            } else {
                return  User::with('restaurants')->where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->paginate($request->paginate ?? 10);
            }
        }
    }
    public function restaurants($request)
    {
        if ($request->status != 'null') {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Restaurant::with('user')
                    ->where('user_id', authUser()->id) // Filter by the authenticated user's ID
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->where('status', $request->status)
                    ->orderBy($request->key, $request->order)
                    ->paginate($request->paginate ?? 10);
            } else {
                return Restaurant::with('user')
                    ->where('user_id', authUser()->id) // Filter by the authenticated user's ID
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->where('status', $request->status)
                    ->paginate($request->paginate ?? 10);
            }
        } else {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Restaurant::with('user')
                    ->where('user_id', authUser()->id) // Filter by the authenticated user's ID
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orderBy($request->key, $request->order)
                    ->paginate($request->paginate ?? 10);
            } else {
                return Restaurant::with('user')
                    ->where('user_id', authUser()->id) // Filter by the authenticated user's ID
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->paginate($request->paginate ?? 10);
            }
        }
    }
    public function chats_and_contacts($request)
    {
        $contacts = User::where('user_type', 0)->where('name', 'LIKE', '%' . $request->search . '%')->get();
        $user = authUser();
        $chats = SuperAdminOwnerChatModel::with('superAdmin', 'owner')->where('owner_id', authUser()->id)->get();
        return ['user' => $user, 'contacts' => $contacts, 'chats' => $chats];
    }
    public function chats($request)
    {
        $chat = SuperAdminOwnerChatModel::with(['superAdmin', 'owner'])->where('owner_id', authUser()->id)->where('super_admin_id', $request->super_admin_id)->get();
        $super_admin = User::where('id', $request->super_admin_id)->first();
        return ['super_admin' => $super_admin, 'chat' => $chat];
    }
    public function createChats($request)
    {
        $new_chat = SuperAdminOwnerChatModel::create([
            'owner_id' => authUser()->id,
            'super_admin_id' => $request->super_admin_id,
            'message' => $request->message,
        'type' => 1
        ]);
        $chats = SuperAdminOwnerChatModel::with('superAdmin', 'owner')->where('owner_id', authUser()->id)->where('id',$new_chat->id)->first();
        Http::post('https://127.0.0.1/send-message', [
            'super_admin_id' => $request->super_admin_id,
            'owner_id' => authUser()->id,
            'message' => $request->message,
            'type' => 0
        ]);
        return ['chats' => $chats,'user' => authUser()->id];
    }
    public function items($request)
    {
        return Item::find(1);
    }
    public function orders($request)
    {
        if ($request->status != 'null') {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Order::with(['user', 'restaurant'])
                    ->where('status', $request->status)
                    ->whereHas('restaurant', function ($query) {
                        $query->where('user_id', authUser()->id);
                    })
                    ->orderBy($request->key, $request->order)
                    ->paginate($request->paginate ?? 10);
            } else {
                return Order::with(['user', 'restaurant'])
                    ->where('status', $request->status)
                    ->whereHas('restaurant', function ($query) {
                        $query->where('user_id', authUser()->id);
                    })
                    ->paginate($request->paginate ?? 10);
            }
        } else {
            if ($request->key !== 'null' && $request->order !== 'null') {
                return Order::with(['user', 'restaurant'])
                    ->whereHas('restaurant', function ($query) {
                        $query->where('user_id', authUser()->id);
                    })
                    ->orderBy($request->key, $request->order)
                    ->paginate($request->paginate ?? 10);
            } else {
                return Order::with(['user', 'restaurant'])
                    ->whereHas('restaurant', function ($query) {
                        $query->where('user_id', authUser()->id);
                    })
                    ->paginate($request->paginate ?? 10);
            }
        }
    }
    public function sales($request)
    {



        $authUserId = authUser()->id;
        $items = Item::whereHas('restaurant', function ($query) use ($authUserId) {
            $query->where('user_id', $authUserId);
        })->count();
        $startDate = null;
        $endDate = null;
        if ($request->time_range === null) {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $sales = Order::whereDate('created_at', Carbon::today())->whereHas('restaurant', function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            })->sum('total');
        } else {
            if ($request->time_range === 'Today') {
                $startDate = Carbon::now()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $sales = Order::whereDate('created_at', Carbon::today())->whereHas('restaurant', function ($query) use ($authUserId) {
                    $query->where('user_id', $authUserId);
                })->sum('total');
            } elseif ($request->time_range === 'This Week') {
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                $sales = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->whereHas('restaurant', function ($query) use ($authUserId) {
                    $query->where('user_id', $authUserId);
                })->sum('total');
            } elseif ($request->time_range === 'This Month') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $sales = Order::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->whereHas('restaurant', function ($query) use ($authUserId) {
                    $query->where('user_id', $authUserId);
                })->sum('total');
            }
        }


        $topRestaurants = Restaurant::select('restaurants.*', DB::raw('SUM(orders.total) as total_sales'))
            ->join('orders', 'orders.restaurant_id', '=', 'restaurants.restaurant_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('restaurants.user_id', $authUserId) // Filter restaurants by the authenticated user's ID
            ->groupBy('restaurants.restaurant_id')
            ->orderByDesc('total_sales')
            ->limit(4)
            ->get();
        $topRestaurantIds = $topRestaurants->pluck('restaurant_id')->toArray();

        // Get the sum of total sales for the rest of the restaurants (excluding the top 4)
        $restOfRestaurantsTotalSales = Restaurant::join('orders', 'orders.restaurant_id', '=', 'restaurants.restaurant_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('restaurants.user_id', $authUserId) // Filter restaurants by the authenticated user's ID
            ->whereNotIn('restaurants.restaurant_id', $topRestaurantIds)
            ->sum('orders.total');

        // Create an object representing the "restaurant" with the total sales of the rest
        $restaurant = new \stdClass();
        $restaurant->restaurant_id = 0; // You can set a custom ID for this pseudo-restaurant if needed
        $restaurant->name = 'Rest of Restaurants'; // Name it as you prefer
        $restaurant->total_sales = $restOfRestaurantsTotalSales;

        // Add the pseudo-restaurant to the top restaurants collection
        $topRestaurants->push($restaurant);
        $currentYear = Carbon::now()->year;
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales')
            ->whereYear('created_at', $currentYear)
            ->whereHas('restaurant', function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $monthlySalesResult = [];
        foreach ($monthlySales as $monthlySale) {
            $monthName = $monthNames[$monthlySale->month];
            $monthlySalesResult[] = [
                'month' => $monthName,
                'sale' => $monthlySale->total_sales,
            ];
        }
        $result = [

            'monthlySales' => $monthlySalesResult,
            'sales' => $sales,

            'items' => $items,
            'topRestaurants' => $topRestaurants,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        return $result;
    }

    public function viewUserById($request)
    {
        $user = User::with('restaurants')->find($request->id); // Assuming there is a User model



        return $user;
    }
    public function viewRestaurantById($request)
    {

        $restaurant = Restaurant::with(['user', 'orders'])
            ->where('id', $request->id)
            ->first();

        $startDateOfWeek = Carbon::now()->startOfWeek();
        $totalOrdersAndSalesPerDay = [];
        $totalWeekOrders = 0;
        $totalWeekSales = 0;

        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startDateOfWeek->copy()->addDays($i);
            $orders = $restaurant->orders()
                ->whereDate('created_at', $currentDate)
                ->get();

            $totalOrders = $orders->count();
            $totalSales = $orders->whereHas('restaurant', function ($query) use ($authUserId) {
                $query->where('user_id', authUser()->id);
            })->sum('total');

            $totalOrdersAndSalesPerDay[$currentDate->toDateString()] = [
                'totalOrders' => $totalOrders,
                'totalSales' => $totalSales,
            ];

            $totalWeekOrders += $totalOrders;
            $totalWeekSales += $totalSales;
        }

        $restaurant->totalOrdersAndSalesPerDay = $totalOrdersAndSalesPerDay;
        $restaurant->totalWeekOrders = $totalWeekOrders;
        $restaurant->totalWeekSales = $totalWeekSales;

        return $restaurant;
    }
    public function updateRestaurantById($request)
    {
        $restaurant = Restaurant::find($request->restaurant['restaurant_id']);

        $restaurant->name = $request->restaurant['name'];
        $restaurant->address = $request->restaurant['address'];
        $restaurant->city = $request->restaurant['city'];
        $restaurant->state = $request->restaurant['state'];
        $restaurant->zip_code = $request->restaurant['zip_code'];
        $restaurant->phone = $request->restaurant['phone'];


        return $restaurant->save();
    }
    public function closeRestaurantById($request)
    {
        $restaurant = Restaurant::find($request->id);
        $restaurant->status = "Deactive";
        return $restaurant->save();
    }
    public function viewRestaurantsByUserId($request)
    {
        return Restaurant::where('user_id', $request->user_id)->get();
    }
    public function viewItemsByOrderId($request)
    {
        return Order::with('user','restaurant', 'orderItems.item')->find($request->order_id);
    }
    public function viewItemById($request)
    {
        return Item::with('restaurant')->find($request->id);
    }
    public function updateUserById($request)
    {

        $user = User::find($request->user['id']);

        $user->name = $request->user['name'];
        $user->email = $request->user['email'];
        $user->phone = $request->user['phone'];
        $user->company = $request->user['company'];
        $user->street = $request->user['street'];
        $user->city = $request->user['city'];
        $user->zip_code = $request->user['zip_code'];

        return $user->save();
    }

    public function deleteUserById($request)
    {
        $user = User::find($request->id);
        return $user->delete();
    }

    public function viewOrderById($request)
    {
        return OrderItem::with('item')->where('order_id', $request->id)->get();
    }
    public function viewOrdersByRestaurantId($request)
    {
        return Order::with(['restaurant', 'user'])->where('restaurant_id', $request->restaurant_id)->paginate($request->paginate ?? 10);
    }
    public function deleteOrderById($request)
    {
        $order = Order::find($request->id);
        return $order->delete();
    }
    public function viewReservationById($request)
    {
        return Reservation::find($request->id);
    }
    public function deleteReservationById($request)
    {
        $reservation = Reservation::find($request->id);
        return $reservation->delete();
    }
    public function approveClaimById($request)
    {
        $claim = Claim::find($request->id);
        $claim->status = 1;
        if ($claim->save()) {
            $restaurant = Restaurant::find($claim->restaurant_id);
            if ($restaurant) {
                $restaurant->user_id = $claim->user_id;
                $restaurant->status = 'Active';
                return $restaurant->save();
            } else {
            }
        }
    }
    public function notifications(){
        $restaurants = Restaurant::where('user_id', authUser()->id)->get();

// Initialize an array to store the notifications
$notifications = [];

foreach ($restaurants as $restaurant) {
    $notificationsForRestaurant = Notification::where('add_data', $restaurant->restaurant_id)->where('type', 0)->get();

    $notifications = array_merge($notifications, $notificationsForRestaurant->toArray());
}

return $notifications;
    }
    public function updateIsReadForAll($request){
        $notifications = Notification::all();
        if($request->read_at === true){
            foreach($notifications as $notification){
                $notification->owner_read_at = Carbon::now();
                $notification->save();
            }
            return response()->json(['read']);
        }else if($request->read_at === false){
            foreach($notifications as $notification){
                $notification->owner_read_at = null;
                $notification->save();
            }
            return response()->json(['un_read']);
        }
        
    }
    public function updateIsReadByNotificationId($request){
        $notification = Notification::find($request->notification_id);
        if($notification->owner_read_at === null){
            $notification->owner_read_at = Carbon::now();
            $notification->save();
        }
    }
    public function deleteNotificationById($request){
        $notification = Notification::find($request->id);
        return $notification->delete();
    }
}
