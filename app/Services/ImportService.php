<?php

namespace App\Services;

use App\Imports\CustomersImport;
use App\Imports\ExpensesImport;
use App\Imports\ExpenseTypesImport;
use App\Imports\FoodCategoriesImport;
use App\Imports\FoodItemsImport;
use App\Imports\IngredientsImport;
use App\Imports\ModifiersImport;
use App\Imports\PaymentMethodsImport;
use App\Imports\ServiceTablesImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportService
{

    public function proccess($request)
    {
        switch ($request->resource) {
            case 'categories':
                Excel::import(new FoodCategoriesImport, $request->file);
                break;
            case 'customers':
                Excel::import(new CustomersImport, $request->file);
                break;
            case 'servicetables':
                Excel::import(new ServiceTablesImport, $request->file);
                break;
            case 'products':
                Excel::import(new FoodItemsImport, $request->file);
                break;

            case 'modifiers':
                Excel::import(new ModifiersImport, $request->file);
                break;

            case 'ingredients':
                Excel::import(new IngredientsImport, $request->file);
                break;
            case 'expenses':
                Excel::import(new ExpensesImport, $request->file);
                break;

            case 'expensetypes':
                Excel::import(new ExpenseTypesImport, $request->file);
                break;

            case 'paymentmethods':
                Excel::import(new PaymentMethodsImport, $request->file);
                break;

            default:
                throw new \Exception (__("please specify resource to import"), 422);
                break;
        }
    }
}
