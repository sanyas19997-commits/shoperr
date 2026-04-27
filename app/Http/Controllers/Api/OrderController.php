<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::with(['user:id,name,email']);

        if ($s = $request->string('q')->toString()) {
            $q->where(function ($w) use ($s) {
                $w->where('number', 'like', "%$s%")
                  ->orWhere('customer_name', 'like', "%$s%")
                  ->orWhere('customer_email', 'like', "%$s%")
                  ->orWhere('customer_phone', 'like', "%$s%");
            });
        }
        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }
        if ($from = $request->input('from')) {
            $q->where('created_at', '>=', $from);
        }
        if ($to = $request->input('to')) {
            $q->where('created_at', '<=', $to);
        }

        return $q->latest()->paginate($request->integer('per_page', 20));
    }

    public function show(Order $order)
    {
        $order->load(['items.product:id,name,slug,sku', 'user']);
        $order->status_label = $order->status_label;
        $order->payment_method_label = $order->payment_method_label;
        $order->delivery_method_label = $order->delivery_method_label;
        return response()->json(['data' => $order]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['nullable', 'string', 'in:' . implode(',', array_keys(Order::STATUSES))],
            'comment' => ['nullable', 'string'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'payment_status' => ['nullable', 'string'],
        ]);

        $before = $order->only(array_keys($data));
        $order->update($data);

        if (isset($data['status']) && $data['status'] !== $before['status']) {
            ActionLog::log('order.status', $order, [
                'from' => $before['status'] ?? null,
                'to' => $data['status'],
            ]);
        }
        ActionLog::log('order.update', $order, $data);

        return response()->json(['data' => $order->fresh()]);
    }

    public function destroy(Request $request, Order $order)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('order.delete', $order);
        $order->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    public function exportCsv(Request $request)
    {
        $q = Order::with('items.product');
        if ($from = $request->input('from')) $q->where('created_at', '>=', $from);
        if ($to = $request->input('to')) $q->where('created_at', '<=', $to);
        if ($status = $request->input('status')) $q->where('status', $status);

        $orders = $q->latest()->get();

        $csv = "Номер;Дата;Клиент;Телефон;Email;Город;Адрес;Способ оплаты;Доставка;Статус;Сумма;Состав\n";
        foreach ($orders as $o) {
            $items = $o->items->map(fn ($i) => "{$i->name} x{$i->quantity}")->implode(' | ');
            $csv .= sprintf(
                "%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%.2f;%s\n",
                $o->number,
                $o->created_at->format('Y-m-d H:i'),
                str_replace(["\r", "\n", ';'], ' ', $o->customer_name ?? ''),
                $o->customer_phone ?? '',
                $o->customer_email ?? '',
                $o->city ?? '',
                str_replace(["\r", "\n", ';'], ' ', $o->address ?? ''),
                $o->payment_method_label,
                $o->delivery_method_label,
                $o->status_label,
                (float) $o->total,
                str_replace(["\r", "\n", ';'], ' ', $items),
            );
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="orders-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }

    public function options()
    {
        return response()->json([
            'statuses' => Order::STATUSES,
            'payment_methods' => Order::PAYMENT_METHODS,
            'delivery_methods' => Order::DELIVERY_METHODS,
        ]);
    }
}
