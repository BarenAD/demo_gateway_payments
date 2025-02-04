<?php

namespace App\Jobs;

use App\Enums\Transactions\TransactionStatues;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Transaction $transaction
    ) {
        //
    }

    public function handle(): void
    {
        $this->transaction->status_id = TransactionStatues::IN_PROGRESS;
        $this->transaction->save();
        sleep(5);
        try {
            if (rand(1,100) > 80) {
                throw new \Error('imitation of an error');
            }
            $this->transaction->status_id = TransactionStatues::SUCCESSFULLY;
            $this->transaction->datetime_completed = now();
            $this->transaction->save();
        } catch (\Throwable $exception) {
            $this->transaction->status_id = TransactionStatues::ERROR;
            $this->transaction->datetime_completed = now();
            $this->transaction->save();
            throw $exception;
        }
    }
}
