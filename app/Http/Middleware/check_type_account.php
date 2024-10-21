<?php

namespace App\Http\Middleware;

use App\Utils\helper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\HelperApi;
use App\Models\Account; // Import your Account model


class check_type_account
{
    use HelperApi;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $account_id= $request->header('Accept-account');

        $account=helper::get_account($account_id);
        if($account && $account->type =='0'){
            return $next($request);
        }else{
            return $this->onError(500,'not allow this account');
        }

    }
}
