<?php

namespace Modules\Settings\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Exception;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Facades\Auth;

class SettingsService
{
    use Crud;

    protected $crudRepository;
    protected $model;

    public function __construct(CrudRepository $crudRepository)
    {
        $this->model = "\\Modules\\Settings\\app\\Models\\Setting";
        $this->crudRepository = $crudRepository;
    }

    public function createSettings($entries)
    {
        // dd($entries);
        unset($entries['_token']);

        $entries['platform'] = json_encode($entries['platform']);
        $entries['payments'] = json_encode($entries['payments']);
        $entries['gateway'] = json_encode($entries['gateway']);

        try {
            foreach ($entries as $key => $data) {
                $this->updateOrCreate(['key' => $key], [
                    'key' => $key,
                    'value' => $data
                ]);

                if (ctype_upper(str_replace('_', '', $key))) {
                    DotenvEditor::setKey($key, $data)->save();
                    DotenvEditor::addEmpty()->save();
                }

                if ($key == 'gateway') {
                    foreach (json_decode($data, true) as $paymentCredential) {
                        $paymentGatewayCredentials = json_decode($paymentCredential, true);
                        foreach ($paymentGatewayCredentials as $var => $credential) {
                            DotenvEditor::setKey($var, $credential)->save();
                        }
                    }
                }
            }

            return [
                'status' => 1,
                'message' => 'Settings Modified Successfully'
            ];
        } catch (Exception $e) {
            return [
                'status' => 0,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getTransformedArray()
    {
        $array = $this->getAllWithoutPagination()->toArray();

        $transformedArray = [];

        foreach ($array as $arr) {
            $transformedArray[$arr['key']] = json_decode($arr['value']) ?: $arr['value'];
        }

        return $transformedArray;
    }

    public function getPosConfiguration()
    {
        $key = "branch_" . request()->branch . "_user_" . Auth::user()->id . "_pos_configuration";
        return $this->getWhereFirst([['key', '=', $key]]);
    }

    public function storePosConfiguration($request)
    {
        $key = "branch_" . request()->branch . "_user_" . Auth::user()->id . "_pos_configuration";
        $this->updateOrCreate(['key' => $key], ['value' => json_encode($request['pos_configuration'])]);
    }
}
