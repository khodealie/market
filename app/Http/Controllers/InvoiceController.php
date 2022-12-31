<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Http\Resources\InvoiceRes;
use App\Models\Invoice;
use App\Models\Product;

class InvoiceController extends Controller
{
    public function addProduct2Cart(Product $product): InvoiceRes
    {
        $invoice = Invoice::firstOrCreate(['status' => InvoiceStatus::NEW, 'user_id' => auth()->user()->id]);
        $invoice->products()->attach($product);
        return new InvoiceRes($invoice);
    }

    public function verifyPayment(Invoice $invoice): InvoiceRes
    {
        $invoice->update(['status' => InvoiceStatus::IN_PROGRESS]);
        return new InvoiceRes($invoice);
    }
}
