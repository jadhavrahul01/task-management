<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout};
use App\Models\User;
use App\Models\Order;
use Livewire\WithPagination;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;

new class extends Component {
    use WithPagination;
    #[Title('Customer Details')]
    public $headers;

    public $user;
    public $orders;

    public function boot(): void
    {
        $this->headers = [['key' => 'id', 'label' => '#', 'class' => 'text-white'], ['key' => 'grand_total', 'label' => 'Amount', 'class' => 'text-white'], ['key' => 'payment_method', 'label' => 'Payment Method', 'class' => ' text-white'], ['key' => 'payment_status', 'label' => 'Payment Status', 'class' => ' text-white'], ['key' => 'order_status', 'label' => 'Order Status', 'class' => 'text-white'], ['key' => 'action', 'label' => 'Action', 'class' => 'w-1 text-white']];
    }

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->orders = Order::where('user_id', $id)->get();
    }
};

?>

<div>
    <div class="breadcrumbs mb-4 text-sm">
        <h1 class="text-2xl font-bold mb-2">
            Employee Details
        </h1>
        <ul>
            <li>
                <a href="{{ route('admin.index') }}" wire:navigate>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.employee.index') }}" wire:navigate>
                    All Employee
                </a>
            </li>
            <li>
                Employee Details
            </li>
        </ul>
    </div>
    <hr class="my-5">
    <div class="container h-full mx-auto">
        <div class="flex flex-col gap-4 xl:flex-row">
            <div>
                <div class="card card-border" role="presentation">
                    <div class="card-body pe-0">
                        <div class="flex flex-col xl:justify-between h-full 2xl:min-w-[360px] mx-auto">
                            <div class="flex items-center gap-4 xl:flex-col">
                                <span class="avatar avatar-circle"
                                    style="width: 90px; height: 90px; min-width: 90px; line-height: 90px; font-size: 12px;">
                                    <img class="avatar-img avatar-circle"
                                        src="{{ $user->image ?: asset('default/user.jpg') }}" alt="{{ $user->name }}"
                                        loading="lazy">
                                </span>
                                <h4 class="font-bold">{{ $user->name }}</h4>
                            </div>
                            <div class="grid grid-cols-1 mt-8 sm:grid-cols-2 xl:grid-cols-1 gap-y-7 gap-x-4">
                                <div>
                                    <span>Email</span>
                                    <p class="font-semibold">
                                        {{ $user->email }}
                                    </p>
                                </div>
                                @isset($user->phone_no)
                                    <div>
                                        <span>Phone</span>
                                        <p class="font-semibold">{{ $user->phone_no }}
                                        </p>
                                    </div>
                                @endisset
                            </div>
                            {{-- <div class="flex flex-col justify-center gap-2 mt-6 xl:flex-row">
                                <x-button label="Delete" class="btn-error" />
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="w-full">
                <div class="border-0 card card-border" role="presentation">
                    <div class="card-body card-gutterless">
                        <div>
                            <h6 class="mb-4 font-bold">All Orders</h6>
                            <hr class="mb-4">
                            <div class="overflow-x-auto">
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            @foreach ($headers as $header)
                                                <th class="{{ $header['class'] }}">
                                                    {{ $header['label'] }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>₹{{ $order->grand_total }}</td>
                                                <td>
                                                    @php
                                                        $icon = [
                                                            'razorpay' => 'frontend-assets/icons/razorpay-icon.svg',
                                                            'cod' => 'frontend-assets/icons/cod-icon.svg',
                                                        ];
                                                    @endphp
                                                    <span class="badge ">
                                                        <img src="{{ asset($icon[$order->payment_method]) }}"
                                                            alt="{{ $order->payment_method }}" class="w-4 h-4 mr-2">
                                                        {{ $order->payment_method }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-error' }}">
                                                        {{ $order->payment_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $status = [
                                                            'submitted' => 'badge-primary',
                                                            'processing' => 'badge-info',
                                                            'completed' => 'badge-success',
                                                            'cancelled' => 'badge-error',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $status[$order->order_status] }}">
                                                        {{ $order->order_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <x-button icon="o-eye" class="bg-transparent border-none"
                                                        link="{{ route('admin.order.show', $order->id) }}" />
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <div class="flex justify-center items center">
                                                        <span class="text-gray-400 dark:text-gray-500">No order
                                                            found.</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
