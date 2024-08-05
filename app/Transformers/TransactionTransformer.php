<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'type' => $transaction->type,
            'account' => $transaction->account->name,
            'paid_at' => $transaction->paid_at,
            'amount' => $transaction->amount,
            'document' => $transaction->document->document_number,
            'contact' => $transaction->contact->name,
            'description' => $transaction->description,
            'closing_balance' => $transaction->closing_balance,
            'payment_method' => $transaction->payment_method,
            'reference' => $transaction->reference,
        ];
    }
}
