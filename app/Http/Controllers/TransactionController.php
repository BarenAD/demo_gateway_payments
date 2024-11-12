<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transactions\TransactionDepositRequest;
use App\Http\Requests\Transactions\TransactionOutputRequest;
use App\Http\Requests\Transactions\TransactionTransferRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        private readonly TransactionService $transactionService
    ) {

    }

    public function transfer(TransactionTransferRequest $request, int $userId): JsonResponse {
        return response()->json(
            $this->transactionService->transfer(
                $userId,
                $request->get('user_to_id'),
                $request->get('currency_from_id'),
                $request->get('currency_to_id'),
                $request->get('value'),
                $request->get('datetime'),
            )
        );
    }

    public function deposit(TransactionDepositRequest $request, int $userId): JsonResponse {
        return response()->json(
            $this->transactionService->deposit(
                $userId,
                $request->get('currency_id'),
                $request->get('value'),
            )
        );
    }

    public function output(TransactionOutputRequest $request, int $userId): JsonResponse {
        return response()->json(
            $this->transactionService->output(
                $userId,
                $request->get('currency_id'),
                $request->get('value'),
            )
        );
    }
}
