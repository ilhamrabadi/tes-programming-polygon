<?php

namespace App\Http\Controllers;

use App\Category;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transactions = Transaction::all();
        $categories = Category::all();
        $balance = 0;
        foreach ($transactions as $t) {
            if ($t->category->category == "income") {
                $balance += $t->amount;
            } else {
                # code...
                $balance -= $t->amount;
            }
        }
        // dd($transactions);
        return view('pakbudi.index', compact('transactions', 'categories', 'balance'));

    }

    public function history(Request $request)
    {
        //
        $filterYear = "";
        if ($request->selectYear == null) {
            $filterYear = Carbon::now()->year;
        } else {
            # code...
            $filterYear = $request->selectYear;
        }
        // dd($filterYear);
        $history = Transaction::whereYear("created_at", $filterYear)->get();
        return view('pakbudi.history', compact('history'));
    }

    public function verify()
    {
        //
        $transactions = Transaction::all();
        $categories = Category::all();
        $balance = 0;
        foreach ($transactions as $t) {
            if ($t->category->category == "income") {
                $balance += $t->amount;
            } else {
                # code...
                $balance -= $t->amount;
            }
        }
        return view('anak.index', compact('transactions', 'categories', 'balance'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $transaction = new Transaction();
        $transaction->created_at = Carbon::now();
        $transaction->updated_at = Carbon::now();
        $transaction->amount = $request->amount;
        $transaction->info = $request->info;
        $transaction->category_id = $request->category_id;
        $transaction->save();
        return redirect("transactions")->with('record-add-succesful', "Data berhasil ditambah");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
        $transaction->updated_at = Carbon::now();
        $transaction->amount = $request->amount;
        $transaction->info = $request->info;
        $transaction->category_id = $request->category_id;
        $transaction->save();
        return back()->with('record-update-succesful', "Data berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        //
        try {
            $transaction = Transaction::find($request->transaction_id);
            $transaction->delete();
            return redirect()->back()->with('record-delete-successful', 'Data berhasil dihapus');
        } catch (\PDOException $e) {
            return redirect()->back()->with('record-delete-failed', 'Data gagal dihapus');
        }
    }

    public function confirm(Request $request)
    {
        //
        $transaction = Transaction::find($request->transaction_id);
        $transaction->status = "1";
        $transaction->save();
        return redirect()->route('transactions.verify')->with('record-confirm-successful', 'Data berhasil dikonfirmasi');
    }
}