<?php

namespace App\Services;

use App\Exports\CustomersExport;
use App\Exports\ExpensesExport;
use App\Exports\ExpenseTypesExport;
use App\Exports\FoodCategoriesExport;
use App\Exports\FoodItemsExport;
use App\Exports\IngredientsExport;
use App\Exports\ModifiersExport;
use App\Exports\PaymentMethodsExport;
use App\Exports\ServiceTablesExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportService
{

    public function proccess($request)
    {
        switch ($request->resource) {
            case 'categories':
                return Excel::download(new FoodCategoriesExport, 'Food_categories.' . $request->format);
                break;

            case 'customers':
                return Excel::download(new CustomersExport, 'Customers.' . $request->format);
                break;

            case 'servicetables':
                return Excel::download(new ServiceTablesExport, 'Service_tables.' . $request->format);
                break;

            case 'products':
                return Excel::download(new FoodItemsExport, 'Food_items.' . $request->format);
                break;

            case 'expenses':
                return Excel::download(new ExpensesExport, 'Expenses.' . $request->format);
                break;

            case 'expensetypes':
                return Excel::download(new ExpenseTypesExport, 'Expense_types.' . $request->format);
                break;

            case 'modifiers':
                return Excel::download(new ModifiersExport, 'Modifiers.' . $request->format);
                break;

            case 'ingredients':
                return Excel::download(new IngredientsExport, 'Ingredients.' . $request->format);
                break;

            case 'paymentmethods':
                return Excel::download(new PaymentMethodsExport, 'Payment_methods.' . $request->format);
                break;

            default:
                throw new \Exception (__("please specify resource to export"), 422);
                break;
        }
    }
}
