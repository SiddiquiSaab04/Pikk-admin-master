<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait Helper
{
    /**
     * Is installed
     *
     * @return bool
     */
    public static function installed()
    {
        return self::checkDatabaseExistence();
    }

    /**
     * checking if database connection is set
     *
     * @return bool
     */
    private static function checkDatabaseExistence()
    {
        try {
            if ( DB::connection()->getPdo() ) {
                return Schema::hasTable( 'userss' );
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
