<?php

namespace App\Models;

use App\Traits\Transactions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, Transactions, SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['balance'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'number', 'currency_code', 'opening_balance', 'closing_balance', 'bank_name', 'bank_phone', 'bank_address', 'enabled', 'created_from', 'created_by'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'opening_balance' => 'double',
        'enabled' => 'boolean',
    ];
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id');
    }
    
    /**
     * Scope to get expense transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpense(Builder $query)
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope to get income transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncome(Builder $query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Get the current balance.
     *
     * @return string
     */
    public function getBalanceAttribute()
    {
        // dd($this->transactions()->get());
        // Opening Balance
        $total = $this->opening_balance;
        // Sum Incomes
        $total += $this->transactions()->where('type', 'income')->sum('amount');

        // Subtract Expenses
        $total -= $this->transactions()->where('type', 'expense')->sum('amount');

        return $total;
    }

}
