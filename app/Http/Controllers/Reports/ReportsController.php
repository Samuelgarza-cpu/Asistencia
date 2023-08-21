<?php

namespace App\Http\Controllers\Reports;
use PDF;
use DateTime;
use Illuminate\Database\Seeder;

use App\Charts\Reports;
use App\Models\Status;
use App\Models\Product;
use App\Models\Support;
use App\Models\SupportProduct;
use App\Models\InsDepSup;
use App\Models\Requisition;
use App\Exports\UsersExport;
use App\Models\Disabilities;
use App\Models\PersonalData;
use App\Models\Address;
use App\Models\Community;
use App\Models\Municipality;
use App\Models\State;
use Illuminate\Http\Request;
use App\Models\RPDDisabilities;
use App\Models\RequestPersonalData;
use App\Http\Controllers\Controller;
use App\Models\DisabilityCategories;
use App\Models\Category;
use App\Models\RequestInsDepSupPro;
use App\Models\RequestSupplierProduct;
use App\Models\ExtPersonalData;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\RequestSupportProduct;
use App\Models\DepartmentInstituteSupportProduct;

class ReportsController extends Controller
{
    private  $chartbackgroundColor = [
        '#A52758','#880FAD','#4B15A3','#2868FC','#2098CC','#73AF48','#D8E851','#FCFC5F','#F9B62F','#F99A25',
        '#641e16','#512e5f','#154360','#0e6251','#0b5345','#186a3b','#78281f','#4a235a','#1b4f72','#145a32',
        '#7d6608','#784212','#7b7d7d','#4d5656','#424949','#17202a','#7e5109','#6e2c00','#626567','#1b2631',
        '#7b241c','#633974','#1a5276','#117864','#0e6655','#1d8348','#943126','#5b2c6f','#21618c','#196f3d',
        '#9a7d0a','#935116','#979a9a','#5f6a6a','#515a5a','#1c2833','#9c640c','#873600','#797d7f','#212f3c',
        '#922b21','#76448a','#1f618d','#148f77','#117a65','#239b56','#b03a2e','#6c3483','#2874a6','#1e8449',
        '#b7950b','#af601a','#b3b6b7','#717d7e','#616a6b','#212f3d','#b9770e','#a04000','#909497','#283747',
        '#a93226','#884ea0','#2471a3','#17a589','#138d75','#28b463','#cb4335','#7d3c98','#2e86c1','#229954',
        '#d4ac0d','#ca6f1e','#d0d3d4','#839192','#707b7c','#273746','#d68910','#ba4a00','#a6acaf','#2e4053',
        '#c0392b','#9b59b6','#2980b9','#1abc9c','#16a085','#2ecc71','#e74c3c','#8e44ad','#3498db','#27ae60',
        '#f1c40f','#e67e22','#ecf0f1','#95a5a6','#7f8c8d','#2c3e50','#f39c12','#d35400','#bdc3c7','#34495e',
        '#cd6155','#af7ac5','#5499c7','#48c9b0','#45b39d','#58d68d','#ec7063','#a569bd','#5dade2','#52be80',
        '#f4d03f','#eb984e','#f0f3f4','#aab7b8','#99a3a4','#566573','#f5b041','#dc7633','#cacfd2','#5d6d7e',
        '#d98880','#c39bd3','#7fb3d5','#76d7c4','#73c6b6','#82e0aa','#f1948a','#bb8fce','#85c1e9','#7dcea0',
        '#f7dc6f','#f0b27a','#f4f6f7','#bfc9ca','#b2babb','#808b96','#f8c471','#e59866','#d7dbdd','#85929e',
        '#e6b0aa','#d7bde2','#a9cce3','#a3e4d7','#a2d9ce','#abebc6','#f5b7b1','#d2b4de','#aed6f1','#a9dfbf',
        '#f9e79f','#f5cba7','#f7f9f9','#d5dbdb','#ccd1d1','#abb2b9','#fad7a0','#edbb99','#e5e7e9','#aeb6bf',
        '#f2d7d5','#ebdef0','#d4e6f1','#d1f2eb','#d0ece7','#d5f5e3','#fadbd8','#e8daef','#d6eaf8','#d4efdf',
        '#fcf3cf','#fae5d3','#fbfcfc','#eaeded','#e5e8e8','#d5d8dc','#fdebd0','#f6ddcc','#f2f3f4','#d6dbdf',
        '#f9ebea','#f5eef8','#eaf2f8','#e8f8f5','#e8f6f3','#eafaf1','#fdedec','#f4ecf7','#ebf5fb','#e9f7ef',
        '#fef9e7','#fdf2e9','#fdfefe','#f4f6f6','#f2f4f4','#eaecee','#fef5e7','#fbeee6','#f8f9f9','#ebedef'
    ];

    private $charthoverBackgroundColor = [
        '#A7194B','#8601AF','#3D01A4','#0247FE','#0391CE','#66B032','#D0EA2B','#FEFE33','#FABC02','#FD5308',
        '#7b241c','#633974','#1a5276','#117864','#0e6655','#1d8348','#943126','#5b2c6f','#21618c','#196f3d',
        '#9a7d0a','#935116','#979a9a','#5f6a6a','#515a5a','#1c2833','#9c640c','#873600','#797d7f','#212f3c',
        '#922b21','#76448a','#1f618d','#148f77','#117a65','#239b56','#b03a2e','#6c3483','#2874a6','#1e8449',
        '#b7950b','#af601a','#b3b6b7','#717d7e','#616a6b','#212f3d','#b9770e','#a04000','#909497','#283747',
        '#a93226','#884ea0','#2471a3','#17a589','#138d75','#28b463','#cb4335','#7d3c98','#2e86c1','#229954',
        '#d4ac0d','#ca6f1e','#d0d3d4','#839192','#707b7c','#273746','#d68910','#ba4a00','#a6acaf','#2e4053',
        '#c0392b','#9b59b6','#2980b9','#1abc9c','#16a085','#2ecc71','#e74c3c','#8e44ad','#3498db','#27ae60',
        '#f1c40f','#e67e22','#ecf0f1','#95a5a6','#7f8c8d','#2c3e50','#f39c12','#d35400','#bdc3c7','#34495e',
        '#cd6155','#af7ac5','#5499c7','#48c9b0','#45b39d','#58d68d','#ec7063','#a569bd','#5dade2','#52be80',
        '#f4d03f','#eb984e','#f0f3f4','#aab7b8','#99a3a4','#566573','#f5b041','#dc7633','#cacfd2','#5d6d7e',
        '#d98880','#c39bd3','#7fb3d5','#76d7c4','#73c6b6','#82e0aa','#f1948a','#bb8fce','#85c1e9','#7dcea0',
        '#f7dc6f','#f0b27a','#f4f6f7','#bfc9ca','#b2babb','#808b96','#f8c471','#e59866','#d7dbdd','#85929e',
        '#e6b0aa','#d7bde2','#a9cce3','#a3e4d7','#a2d9ce','#abebc6','#f5b7b1','#d2b4de','#aed6f1','#a9dfbf',
        '#f9e79f','#f5cba7','#f7f9f9','#d5dbdb','#ccd1d1','#abb2b9','#fad7a0','#edbb99','#e5e7e9','#aeb6bf',
        '#f2d7d5','#ebdef0','#d4e6f1','#d1f2eb','#d0ece7','#d5f5e3','#fadbd8','#e8daef','#d6eaf8','#d4efdf',
        '#fcf3cf','#fae5d3','#fbfcfc','#eaeded','#e5e8e8','#d5d8dc','#fdebd0','#f6ddcc','#f2f3f4','#d6dbdf',
        '#f9ebea','#f5eef8','#eaf2f8','#e8f8f5','#e8f6f3','#eafaf1','#fdedec','#f4ecf7','#ebf5fb','#e9f7ef',
        '#fef9e7','#fdf2e9','#fdfefe','#f4f6f6','#f2f4f4','#eaecee','#fef5e7','#fbeee6','#f8f9f9','#ebedef',
        '#641e16','#512e5f','#154360','#0e6251','#0b5345','#186a3b','#78281f','#4a235a','#1b4f72','#145a32',
        '#7d6608','#784212','#7b7d7d','#4d5656','#424949','#17202a','#7e5109','#6e2c00','#626567','#1b2631'
    ];
    public function index(){


        $insDepSup = InsDepSup::where('departmentsInstitutes_id','=',session('department_institute_id'))->get();

        $supports =array();
        foreach($insDepSup as $element){
            $support = Support::find($element->supports_id);
            array_push($supports, $support);
        }


        $data = array(
            'supports' => $supports,

        );
        return view('reports.reports', $data);

    }

    public function reports(Request $request){
        switch($request->action){
            case 'productsFilter':
                $iDSP = InsDepSup::where('supports_id','=',$request->support_id)->get();
                $data = [];
                $count = 0;
                foreach($iDSP as $value){
                    $product = Product::find($value->products_id);
                    $data[$count] = $product;
                    $count++;
                }
                return $data;
            break;
        }
        return array();
    }

    public function rdIndex(){
        $catDisability=DisabilityCategories::all();
        $disability=Disabilities::all();

        $defaultData1 = array();
        $defaultNames1 = array();
        $defaultLegend1 = array();
        $defaultbgColor1 = array();
        $defaulthbgColor1 = array();
        $i = 0;
        foreach($catDisability as $element){
            array_push($defaultData1, 1);
            array_push($defaultNames1, $element->name);
            array_push($defaultLegend1, ["color" => $this->chartbackgroundColor[$i], "name" => $element->name, "hover" => $this->charthoverBackgroundColor[$i]]);
            array_push($defaultbgColor1, $this->chartbackgroundColor[$i]);
            array_push($defaulthbgColor1, $this->charthoverBackgroundColor[$i]);
            $i++;
        }

        $defaultData2 = array();
        $defaultNames2 = array();
        $defaultLegend2 = array();
        $defaultbgColor2 = array();
        $defaulthbgColor2 = array();
        foreach($disability as $element){
            array_push($defaultData2, 1);
            array_push($defaultNames2, $element->name);
            array_push($defaultLegend2, ["color" => $this->chartbackgroundColor[$i], "name" => $element->name, "hover" => $this->charthoverBackgroundColor[$i]]);
            array_push($defaultbgColor2, $this->chartbackgroundColor[$i]);
            array_push($defaulthbgColor2, $this->charthoverBackgroundColor[$i]);
            $i++;
        }

        $defaultData3 = array();
        $defaultNames3 = array();
        $defaultLegend3 = array();
        $defaultbgColor3 = array();
        $defaulthbgColor3 = array();
        array_push($defaultData3, 1);
        array_push($defaultNames3, "");
        array_push($defaultLegend3, ["color" => $this->chartbackgroundColor[0], "name" => "", "hover" => $this->charthoverBackgroundColor[0]]);
        array_push($defaultbgColor3, $this->chartbackgroundColor[0]);
        array_push($defaulthbgColor3, $this->charthoverBackgroundColor[0]);

        $data = array(
            'disabilitiescategory' => $catDisability,
            'disabilities' => $disability,
            'defaultData1' => $defaultData1,
            'defaultNames1' => $defaultNames1,
            'defaultLegend1' => $defaultLegend1,
            'defaultbgColor1' => $defaultbgColor1,
            'defaulthbgColor1' => $defaulthbgColor1,
            'defaultData2' => $defaultData2,
            'defaultNames2' => $defaultNames2,
            'defaultLegend2' => $defaultLegend2,
            'defaultbgColor2' => $defaultbgColor2,
            'defaulthbgColor2' => $defaulthbgColor2,
            'defaultData3' => $defaultData3,
            'defaultNames3' => $defaultNames3,
            'defaultLegend3' => $defaultLegend3,
            'defaultbgColor3' => $defaultbgColor3,
            'defaulthbgColor3' => $defaulthbgColor3
            // 'chart' => $prueba
        );

        return view('reports.reportsdisabilities', $data);
    }

    public function rrIndex(){
        $categoryRequest = array();
        $productsRequest = array();
        $department_supports_category = InsDepSup::select('categories.id','categories.name')
                                        ->join("supports_products", 'ins_dep_sup.supports_id', "=", "supports_products.supports_id")
                                        ->join("categories", "supports_products.categories_id", "=", "categories.id")
                                        ->where('departmentsInstitutes_id','=',session('department_institute_id'))->distinct()->get();
        $count_dsc = $department_supports_category->count();
        for($i = 0; $i < $count_dsc; $i++)
        {
            array_push($categoryRequest, $department_supports_category[$i]);
            $valueDSC = $department_supports_category[$i];
            $product = Product::where('categories_id', '=', $valueDSC->id)->get();
            $count_su = $product->count();
            for($j = 0; $j < $count_su; $j++){
                array_push($productsRequest, $product[$j]);
            }
        }
        //dd($productsRequest);
        $defaultProductsData = array();
        $defaultProductsNames = array();
        $defaultLegend1 = array();
        $defaultbgColor1 = array();
        $defaulthbgColor1 = array();
        $i = 0;
        foreach($productsRequest as $element){
            array_push($defaultProductsData, 1);
            array_push($defaultProductsNames, $element->name);
            array_push($defaultLegend1, ["color" => $this->chartbackgroundColor[$i], "name" => $element->name, "hover" => $this->charthoverBackgroundColor[$i]]);
            array_push($defaultbgColor1, $this->chartbackgroundColor[$i]);
            array_push($defaulthbgColor1, $this->charthoverBackgroundColor[$i]);
            $i++;
        }

        $defaultCategoriesData = array();
        $defaultCategoriesNames = array();
        $defaultLegend2 = array();
        $defaultbgColor2 = array();
        $defaulthbgColor2 = array();
        $i = 0;
        foreach($categoryRequest as $element){
            array_push($defaultCategoriesData, 1);
            array_push($defaultCategoriesNames, $element->name);
            array_push($defaultLegend2, ["color" => $this->chartbackgroundColor[$i], "name" => $element->name, "hover" => $this->charthoverBackgroundColor[$i]]);
            array_push($defaultbgColor2, $this->chartbackgroundColor[$i]);
            array_push($defaulthbgColor2, $this->charthoverBackgroundColor[$i]);
            $i++;
        }

        $defaultData3 = array();
        $defaultNames3 = array();
        $defaultLegend3 = array();
        $defaultbgColor3 = array();
        $defaulthbgColor3 = array();
        array_push($defaultData3, 1);
        array_push($defaultNames3, "");
        array_push($defaultLegend3, ["color" => $this->chartbackgroundColor[0], "name" => "", "hover" => $this->charthoverBackgroundColor[0]]);
        array_push($defaultbgColor3, $this->chartbackgroundColor[0]);
        array_push($defaulthbgColor3, $this->charthoverBackgroundColor[0]);

        //dd($defaultNames);
        $data = array(
            'categories' => $categoryRequest,
            'products' => $productsRequest,
            'defaultNames1' => $defaultProductsNames,
            'defaultData1' => $defaultProductsData,
            'defaultLegend1' => $defaultLegend1,
            'defaultbgColor1' => $defaultbgColor1,
            'defaulthbgColor1' => $defaulthbgColor1,
            'defaultNames2' => $defaultCategoriesNames,
            'defaultData2' => $defaultCategoriesData,
            'defaultLegend2' => $defaultLegend2,
            'defaultbgColor2' => $defaultbgColor2,
            'defaulthbgColor2' => $defaulthbgColor2,
            'defaultNames3' => $defaultNames3,
            'defaultData3' => $defaultData3,
            'defaultLegend3' => $defaultLegend3,
            'defaultbgColor3' => $defaultbgColor3,
            'defaulthbgColor3' => $defaulthbgColor3
            // 'chart' => $prueba
        );
        //dd($data);
        return view('reports.reportsrequests', $data);
    }

    public function reportsDisabilities(Request $request){
        switch($request->input('action')){

            case 'disabilityFilter':
                if($request->catdisabilities_id == 0)
                    $disability = Disabilities::all();
                else
                    $disability=Disabilities::where('disabilitycategories_id','=',$request->catdisabilities_id)->get();
                return $disability;
            break;

            case 'search_disabilities':
                $from = $request->from;
                $until = $request->until;
                $catdisabilities_id = $request->catdisabilities_id;
                $disability_id = $request->disability_id;
                $area = $request->area;
                $dataInformation = array();

                $dataCategories = array();
                $dataCategoriesNames = array();
                $dataCategoriesValues = array();
                $defaultLegend1 = array();
                $defaultbgColor1 = array();
                $defaulthbgColor1 = array();

                $dataDisabilities = array();
                $dataDisabilitiesNames = array();
                $dataDisabilitiesValues = array();
                $defaultLegend2 = array();
                $defaultbgColor2 = array();
                $defaulthbgColor2 = array();

                $dataAreas = array();
                $dataAreasNames = array();
                $dataAreasValues = array();
                $defaultLegend3 = array();
                $defaultbgColor3 = array();
                $defaulthbgColor3 = array();

                if ($from != null && $until != null){
                    $from = New Datetime($from);
                    $until = New Datetime($until);

                    $dateFrom = date_format($from, 'Y-m-d');
                    $dateUntil = date_format($until, 'Y-m-d');
                    $count = 1;

                    if($area != null && $area != "")
                        $requests = Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                               ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                               ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                               ->leftJoin('communities as c','a.communities_id', 'c.id')
                                               ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                               ->leftJoin('states as s','m.states_id','s.id')
                                               ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',a.internalNumber,' ',c.name,' ,' , m.name,' ,' ,s.name) AS address"),
                                                                      DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                      'pD.curp', 'rPD.id as requestPDId')
                                               ->where('date', '>=', $dateFrom)
                                               ->where('date', '<=', $dateUntil)
                                               ->where('area', '=', $area)
                                               ->get();
                    else
                        $requests =Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                              ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                              ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                              ->leftJoin('communities as c','a.communities_id', 'c.id')
                                              ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                              ->leftJoin('states as s','m.states_id','s.id')
                                              ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',IFNULL(a.internalNumber, ''),' ',c.name,' ,' , m.name,' ,' ,s.name) AS fulladdress"),
                                                                     DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                     'pD.curp', 'rPD.id as requestPDId', 'rPD.personalData_id')
                                              ->where('date', '>=', $dateFrom)
                                              ->where('date', '<=', $dateUntil)
                                              ->get();

                    foreach ($requests as $value) {
                        $disabilityCategoryname = "";
                        $disabilityname = "";
                        $value->disabilityCategoryfilter = 0;                       
                        $value->disabilityfilter = 0;
                       
                        $rpd_disabilities = RPDDisabilities::where('requestsPersonalData_id', '=',$value->requestPDId)->get();
                        $countD = $rpd_disabilities->count();
                        for ($j=0; $j < $countD; $j++) {
                            $disabilityCategory = DisabilityCategories::find($rpd_disabilities[$j]->disabilitycategories_id);
                            $disability = Disabilities::find($rpd_disabilities[$j]->disability_id);

                            if ($catdisabilities_id != null && $catdisabilities_id != 0 && $catdisabilities_id == $disabilityCategory->id) {
                                $value->disabilityCategoryfilter = 1;                       
                            }
                            $value->disabilityCategoryid = $disabilityCategory->id;
                            $disabilityCategoryname = $disabilityCategoryname.$disabilityCategory->name.'/';

                            if ($disability_id != null && $disability_id != 0 && $disability_id == $disability->id) {
                                $value->disabilityfilter = 1;                       
                            }

                            $value->disabilityid = $disability->id;
                            $disabilityname = $disabilityname.$disability->name.'/';                    
                        }
                        $value->disabilityCategory = substr($disabilityCategoryname, strlen($disabilityCategoryname)-1, 1) == '/' ? substr($disabilityCategoryname, 0, strlen($disabilityCategoryname)-1) : $disabilityCategoryname ;
                        $value->disability = substr($disabilityname, strlen($disabilityname)-1, 1) == '/' ? substr($disabilityname, 0, strlen($disabilityname)-1) : $disabilityname ;

                        $value->number = $count;
                        $count++;
                        $value->actions = '<a class="show" id="show" title="Ver Datos Completos"> <i class="fas fa-eye"></i></a>';
                    }

                    if ($catdisabilities_id != null && $catdisabilities_id != 0) {
                        $requests=$requests->where('disabilityCategoryfilter', '=', 1);
                    }
                    if ($disability_id != null && $disability_id != 0) {
                        $requests=$requests->where( 'disabilityfilter', '=', 1);
                    }
                        
                    $category = $requests->groupBy('disabilityCategory')
                                            ->map(function ($row) {
                                                return $row->count();
                                            });

                    $disabilities = $requests->groupBy('disability')
                                            ->map(function ($row) {
                                                    return $row->count();
                                                });

                    $areas = $requests->groupBy('area')
                                      ->map(function ($row) {
                                            return $row->count();
                                        });

                    foreach($requests as $element){
                        array_push($dataInformation, $element);
                    }

                    $myArray = json_decode(json_encode($category), true);
                    $categoriesNames = array_keys($myArray);
                    $i = 0;
                    foreach($myArray as $elem){
                        array_push($dataCategories, [$categoriesNames[$i], $elem]);
                        array_push($dataCategoriesNames, $categoriesNames[$i]);
                        array_push($dataCategoriesValues, $elem);
                        array_push($defaultLegend1, ["color" => $this->chartbackgroundColor[$i], "name" => $categoriesNames[$i], "hover" => $this->charthoverBackgroundColor[$i]]);
                        array_push($defaultbgColor1, $this->chartbackgroundColor[$i]);
                        array_push($defaulthbgColor1, $this->charthoverBackgroundColor[$i]);
                        $i++;
                    }

                    $myArray = json_decode(json_encode($disabilities), true);
                    $disabilitiesNames = array_keys($myArray);
                    $i = 0;
                    foreach($myArray as $elem){
                        array_push($dataDisabilities, [$disabilitiesNames[$i], $elem]);
                        array_push($dataDisabilitiesNames, $disabilitiesNames[$i]);
                        array_push($dataDisabilitiesValues, $elem);
                        array_push($defaultLegend2, ["color" => $this->chartbackgroundColor[$i+3], "name" => $disabilitiesNames[$i], "hover" => $this->charthoverBackgroundColor[$i+3]]);
                        array_push($defaultbgColor2, $this->chartbackgroundColor[$i+3]);
                        array_push($defaulthbgColor2, $this->charthoverBackgroundColor[$i+3]);
                        $i++;
                    }

                    $myArray = json_decode(json_encode($areas), true);
                    //dd($myArray);
                    $areasNames = array_keys($myArray);
                    $i = 0;
                    foreach($myArray as $elem){
                        array_push($dataAreas, [$areasNames[$i], $elem]);
                        array_push($dataAreasNames, $areasNames[$i]);
                        array_push($dataAreasValues, $elem);
                        array_push($defaultLegend3, ["color" => $this->chartbackgroundColor[$i+5], "name" => $areasNames[$i], "hover" => $this->charthoverBackgroundColor[$i+5]]);
                        array_push($defaultbgColor3, $this->chartbackgroundColor[$i+5]);
                        array_push($defaulthbgColor3, $this->charthoverBackgroundColor[$i+5]);
                        $i++;
                    }

                    $information = array(
                        'dataInformation' => $dataInformation,
                        'dataCategories' => $dataCategories,
                        'defaultNames1' => $dataCategoriesNames,
                        'defaultData1' => $dataCategoriesValues,
                        'defaultLegend1' => $defaultLegend1,
                        'defaultbgColor1' => $defaultbgColor1,
                        'defaulthbgColor1' => $defaulthbgColor1,
                        'defaultNames2' => $dataDisabilitiesNames,
                        'defaultData2' => $dataDisabilitiesValues,
                        'defaultLegend2' => $defaultLegend2,
                        'defaultbgColor2' => $defaultbgColor2,
                        'defaulthbgColor2' => $defaulthbgColor2,
                        'defaultNames3' => $dataAreasNames,
                        'defaultData3' => $dataAreasValues,
                        'defaultLegend3' => $defaultLegend3,
                        'defaultbgColor3' => $defaultbgColor3,
                        'defaulthbgColor3' => $defaulthbgColor3
                    );
                    //dd($information);
                    return $information;
                }
            break;

            default:

            break;

        }

        switch($request->btn){
            case 'PDF':
                $from = $request->from;
                $until = $request->until;
                $catdisabilities_id = $request->catdisabilities_id;
                $disability_id = $request->disability_id;
                $area = $request->area;
                $dataInformation = array();

                if ($from != null && $until != null){
                    $from = New Datetime($from);
                    $until = New Datetime($until);

                    $dateFrom = date_format($from, 'Y-m-d');
                    $dateUntil = date_format($until, 'Y-m-d');
                    $count = 1;

                    if($area != null && $area != "")
                        $requests = Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                               ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                               ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                               ->leftJoin('communities as c','a.communities_id', 'c.id')
                                               ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                               ->leftJoin('states as s','m.states_id','s.id')
                                               ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',a.internalNumber,' ',c.name,' ,' , m.name,' ,' ,s.name) AS address"),
                                                                      DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                      'pD.curp', 'rPD.id as requestPDId')
                                               ->where('date', '>=', $dateFrom)
                                               ->where('date', '<=', $dateUntil)
                                               ->where('area', '=', $area)
                                               ->get();
                    else
                        $requests =Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                              ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                              ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                              ->leftJoin('communities as c','a.communities_id', 'c.id')
                                              ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                              ->leftJoin('states as s','m.states_id','s.id')
                                              ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',a.internalNumber,' ',c.name,' ,' , m.name,' ,' ,s.name) AS address"),
                                                                     DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                     'pD.curp', 'rPD.id as requestPDId')
                                              ->where('date', '>=', $dateFrom)
                                              ->where('date', '<=', $dateUntil)
                                              ->get();

                    foreach ($requests as $value) {
                        $requestPersonalData = RequestPersonalData::where('requests_id', '=', $value->id)->get();
                        foreach ($requestPersonalData as $element) {
                            $personalData = PersonalData::find($element->personalData_id);
                            $addresses = Address::find($personalData->addresses_id);
                            $community = Community::find($addresses->communities_id);
                            $municipality = Municipality::find($community->municipalities_id);
                            $state = State::find($municipality->states_id);
                            $value->address = $addresses->street.' #'.$addresses->externalNumber.' '.$addresses->internalNumber.' '.$community->name.' ,'.$municipality->name.' ,'.$state->name;

                            $rpd_disabilities = RPDDisabilities::where('requestsPersonalData_id', '=',$element->id)->get();
                            foreach ($rpd_disabilities as $rpdD) {
                                $disabilityCategory = DisabilityCategories::find($rpdD->disabilitycategories_id);
                                $disability = Disabilities::find($rpdD->disability_id);

                                $value->disabilityCategoryid = $disabilityCategory->id;
                                $value->disabilityCategory = $disabilityCategory->name;
                                $value->disabilityid = $disability->id;
                                $value->disability = $disability->name;

                            }
                            $value->personalData = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                        }
                        $value->number = $count;
                        $count++;
                    }

                    if ($catdisabilities_id != null && $catdisabilities_id != 0)
                        $requests= $requests->where('disabilityCategoryid', '=', $catdisabilities_id);
                    if ($disability_id != null && $disability_id != 0)
                        $requests= $requests->where( 'disabilityid', '=', $disability_id);
                    foreach($requests as $element){
                        array_push($dataInformation, $element);
                    }

                    $countarray = count($dataInformation) - 1 ;

                    $title1 = 'Reporte de Discapacidades';
                    $title2 = 'del '.$from->format('d-m-Y').' al '.$until->format('d-m-Y');
                    $images_path = public_path('assets/img/');
                    $data = array(
                        'title1' => $title1,
                        'title2' => $title2,
                        'dataInformation' => $dataInformation,
                        'images_path' => $images_path,
                        'count'=>$countarray
                    );

                    $pdf = PDF::loadView('PDF.reportDisabilities',  $data);
                    $pdf->setPaper('A4', 'portrait');
                    return $pdf->stream('pdf_file.pdf');
                }
                break;
            case 'excel':

                $from = $request->from;
                $until = $request->until;
                $catdisabilities_id = $request->catdisabilities_id;
                $disability_id = $request->disability_id;
                $area = $request->area;
                $dataInformation = array();

                if ($from != null && $until != null){

                    $from = New Datetime($from);
                    $until = New Datetime($until);

                    $dateFrom = date_format($from, 'Y-m-d');
                    $dateUntil = date_format($until, 'Y-m-d');
                    $count = 1;

                    if($area != null && $area != "")
                        $requests = Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                               ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                               ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                               ->leftJoin('communities as c','a.communities_id', 'c.id')
                                               ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                               ->leftJoin('states as s','m.states_id','s.id')
                                               ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',a.internalNumber,' ',c.name,' ,' , m.name,' ,' ,s.name) AS address"),
                                                                      DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                      'pD.curp', 'rPD.id as requestPDId')
                                               ->where('date', '>=', $dateFrom)
                                               ->where('date', '<=', $dateUntil)
                                               ->where('area', '=', $area)
                                               ->get();
                    else
                        $requests =Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                              ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                              ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                              ->leftJoin('communities as c','a.communities_id', 'c.id')
                                              ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                              ->leftJoin('states as s','m.states_id','s.id')
                                              ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',a.internalNumber,' ',c.name,' ,' , m.name,' ,' ,s.name) AS address"),
                                                                     DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                     'pD.curp', 'rPD.id as requestPDId')
                                              ->where('date', '>=', $dateFrom)
                                              ->where('date', '<=', $dateUntil)
                                              ->get();

                    foreach ($requests as $value) {
                        $requestPersonalData = RequestPersonalData::where('requests_id', '=', $value->id)->get();
                        foreach ($requestPersonalData as $element) {
                            $personalData = PersonalData::find($element->personalData_id);
                            $addresses = Address::find($personalData->addresses_id);
                            $community = Community::find($addresses->communities_id);
                            $municipality = Municipality::find($community->municipalities_id);
                            $state = State::find($municipality->states_id);
                            $value->address = $addresses->street.' #'.$addresses->externalNumber.' '.$addresses->internalNumber.' '.$community->name.' ,'.$municipality->name.' ,'.$state->name;

                            $rpd_disabilities = RPDDisabilities::where('requestsPersonalData_id', '=',$element->id)->get();
                            foreach ($rpd_disabilities as $rpdD) {
                                $disabilityCategory = DisabilityCategories::find($rpdD->disabilitycategories_id);
                                $disability = Disabilities::find($rpdD->disability_id);

                                $value->disabilityCategoryid = $disabilityCategory->id;
                                $value->disabilityCategory = $disabilityCategory->name;
                                $value->disabilityid = $disability->id;
                                $value->disability = $disability->name;

                            }
                            $value->personalData = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                        }
                        $value->number = $count;
                        $count++;
                    }

                    if ($catdisabilities_id != null && $catdisabilities_id != 0)
                        $requests= $requests->where('disabilityCategoryid', '=', $catdisabilities_id);
                    if ($disability_id != null && $disability_id != 0)
                        $requests= $requests->where( 'disabilityid', '=', $disability_id);
                }

                array_push($dataInformation, ['#','Folio','Fecha','Nombre', 'CURP', 'Dirección', 'Categoria Discapacidad', 'Discapacidad', 'Área']);
                foreach($requests as $element){
                    array_push($dataInformation, [$element->number, $element->folio, $element->date, $element->personalData, $element->curpPetitioner, $element->address, $element->disabilityCategory, $element->disability, $element->area]);
                }
                $file = 'RepDiscapacidades '.$from->format('Ymd').' - '.$until->format('Ymd').'.xlsx';
                //$requests1 = Requisition::where('date', '>=', $dateFrom)->where('date', '<=', $dateUntil)->get();
                $userExample = new UsersExport([$dataInformation]);
                return Excel::download($userExample, $file);

                break;
                case 'excel':
                    $from = $request->from;
                    $until = $request->until;
                    $catdisabilities_id = $request->catdisabilities_id;
                    $disability_id = $request->disability_id;
                    $area = $request->area;
                    $dataInformation = array();

                    if ($from != null && $until != null){
                        $from = New Datetime($from);
                        $until = New Datetime($until);

                        $dateFrom = date_format($from, 'Y-m-d');
                        $dateUntil = date_format($until, 'Y-m-d');
                        $count = 1;

                        if($area != null && $area != "")
                            $requests = Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                                ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                                ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                                ->leftJoin('communities as c','a.communities_id', 'c.id')
                                                ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                                ->leftJoin('states as s','m.states_id','s.id')
                                                ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',a.internalNumber,' ',c.name,' ,' , m.name,' ,' ,s.name) AS address"),
                                                                        DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                        'pD.curp', 'rPD.id as requestPDId')
                                                ->where('date', '>=', $dateFrom)
                                                ->where('date', '<=', $dateUntil)
                                                ->where('area', '=', $area)
                                                ->get();
                        else
                            $requests =Requisition::join('requests_personal_data as rPD', 'requests.id', 'rPD.requests_id')
                                                ->leftJoin('personalData as pD', 'rPD.personalData_id', 'pD.id')
                                                ->leftJoin('addresses as a', 'pD.addresses_id', 'a.id')
                                                ->leftJoin('communities as c','a.communities_id', 'c.id')
                                                ->leftJoin('municipalities as m', 'c.municipalities_id','m.id')
                                                ->leftJoin('states as s','m.states_id','s.id')
                                                ->select('requests.*', DB::raw("CONCAT(a.street,' #',a.externalNumber,' ',a.internalNumber,' ',c.name,' ,' , m.name,' ,' ,s.name) AS address"),
                                                                        DB::raw("CONCAT(pD.name,' ',pD.lastName,' ',pD.secondLastName) AS personalData "),
                                                                        'pD.curp', 'rPD.id as requestPDId')
                                                ->where('date', '>=', $dateFrom)
                                                ->where('date', '<=', $dateUntil)
                                                ->get();

                        foreach ($requests as $value) {
                            $requestPersonalData = RequestPersonalData::where('requests_id', '=', $value->id)->get();
                            foreach ($requestPersonalData as $element) {
                                $personalData = PersonalData::find($element->personalData_id);
                                $addresses = Address::find($personalData->addresses_id);
                                $community = Community::find($addresses->communities_id);
                                $municipality = Municipality::find($community->municipalities_id);
                                $state = State::find($municipality->states_id);
                                $value->address = $addresses->street.' #'.$addresses->externalNumber.' '.$addresses->internalNumber.' '.$community->name.' ,'.$municipality->name.' ,'.$state->name;

                                $rpd_disabilities = RPDDisabilities::where('requestsPersonalData_id', '=',$element->id)->get();
                                foreach ($rpd_disabilities as $rpdD) {
                                    $disabilityCategory = DisabilityCategories::find($rpdD->disabilitycategories_id);
                                    $disability = Disabilities::find($rpdD->disability_id);

                                    $value->disabilityCategoryid = $disabilityCategory->id;
                                    $value->disabilityCategory = $disabilityCategory->name;
                                    $value->disabilityid = $disability->id;
                                    $value->disability = $disability->name;

                                }
                                $value->personalData = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                            }
                            $value->number = $count;
                            $count++;
                        }

                        if ($catdisabilities_id != null && $catdisabilities_id != 0)
                            $requests= $requests->where('disabilityCategoryid', '=', $catdisabilities_id);

                        if ($disability_id != null && $disability_id != 0)
                            $requests= $requests->where( 'disabilityid', '=', $disability_id);

                        foreach($requests as $element){
                            array_push($dataInformation, $element);
                        }

                        $countarray = count($dataInformation) - 1 ;

                        $title = 'Reporte de Discapacidades del '.$from->format('d-m-Y').' al '.$until->format('d-m-Y');

                        $data = array(
                            'title' => $title,
                            'dataInformation' => $dataInformation,
                            'count'=>$countarray
                        );
                        return Excel::download(new UsersExport($data), 'Discapacidades.xlsx');

                    }


                    break;
                default:
                break;
        }
    }

    public function reportsRequests(Request $request){
        switch($request->input('action')){
            case 'productFilter':
                if($request->categories_id == 0) {
                    $productsRequest = array();
                    $department_supports_category = InsDepSup::select('categories.id','categories.name')
                                                    ->join("supports_products", 'ins_dep_sup.supports_id', "=", "supports_products.supports_id")
                                                    ->join("categories", "supports_products.categories_id", "=", "categories.id")
                                                    ->where('departmentsInstitutes_id','=',session('department_institute_id'))->distinct()->get();
                    $count_dsc = $department_supports_category->count();
                    for($i = 0; $i < $count_dsc; $i++)
                    {
                        $valueDSC = $department_supports_category[$i];
                        $products = Product::where('categories_id', '=', $valueDSC->id)->get();
                        $count_su = $products->count();
                        for($j = 0; $j < $count_su; $j++){
                            array_push($productsRequest, $products[$j]);
                        }
                    }
                }
                else
                {
                    $productsRequest = array();
                    $products = Product::where('categories_id', '=', $request->categories_id)->get();
                    $count_su = $products->count();
                    for($j = 0; $j < $count_su; $j++){
                        array_push($productsRequest, $products[$j]);
                    }
                }
                return $productsRequest;
            break;

            case 'search_requests':
                $from = $request->from;
                $until = $request->until;
                $type = $request->type;
                $categories_id = $request->categories_id;
                $products_id = $request->products_id;
                $area = $request->area;
                $dataInformation = array();

                $dataProducts = array();
                $dataProductsNames = array();
                $dataProductsValues = array();
                $defaultLegend1 = array();
                $defaultbgColor1 = array();
                $defaulthbgColor1 = array();

                $dataCategories = array();
                $dataCategoriesNames = array();
                $dataCategoriesValues = array();
                $defaultLegend2 = array();
                $defaultbgColor2 = array();
                $defaulthbgColor2 = array();

                $dataAreas = array();
                $dataAreasNames = array();
                $dataAreasValues = array();
                $defaultLegend3 = array();
                $defaultbgColor3 = array();
                $defaulthbgColor3 = array();

                if ($from != null && $until != null){
                    $from = New Datetime($from);
                    $until = New Datetime($until);

                    $dateFrom = date_format($from, 'Y-m-d');
                    $dateUntil = date_format($until, 'Y-m-d');
                    $count = 1;

                    if($area != null && $area != "")
                        $requests = Requisition::where('date', '>=', $dateFrom)->where('date', '<=', $dateUntil)->where('area', '=', $area)->get();
                    else
                        $requests = Requisition::where('date', '>=', $dateFrom)->where('date', '<=', $dateUntil)->get();
                    if($type != null && $type != "0")
                        $requests =  $requests->where('type', '=', $type);

                    foreach ($requests as $value) {
                        $requestPersonalData = RequestPersonalData::where('requests_id', '=', $value->id)->get();
                        foreach ($requestPersonalData as $element) {
                            $personalData = PersonalData::find($element->personalData_id);
                            if ($personalData != null){
                                $addresses = Address::find($personalData->addresses_id);
                                if ($addresses != null){
                                    $community = Community::find($addresses->communities_id);
                                    $municipality = Municipality::find($community->municipalities_id);
                                    $state = State::find($municipality->states_id);
                                    $value->address = $addresses->street.' #'.$addresses->externalNumber.' '.$addresses->internalNumber.' '.$community->name.' ,'.$municipality->name.' ,'.$state->name;
                                    $value->beneficiaries = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                                    $value->beneficiariesCurp = $personalData->curp;
                                }
                            }
                            $extpersonaldata = ExtPersonalData::find($personalData->id);
                            if ($extpersonaldata !=  null)
                                $value->beneficiariesNumber = $extpersonaldata->number;

                            $rpd_disabilities = RPDDisabilities::where('requestsPersonalData_id', '=',$element->id)->get();
                            foreach ($rpd_disabilities as $rpdD) {
                                $disabilityCategory = DisabilityCategories::find($rpdD->disabilitycategories_id);
                                $disability = Disabilities::find($rpdD->disability_id);

                                $value->disabilityCategoryid = $disabilityCategory->id;
                                $value->disabilityCategory = $disabilityCategory->name;
                                $value->disabilityid = $disability->id;
                                $value->disability = $disability->name;
                            }
                            $value->personalData = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                        }

                        if ($value->type == "ts") {
                            $requests_idsp = RequestInsDepSupPro::select("requests_ins_dep_sup_pro.requests_id", "products.id", "products.name", "categories.name AS categoryname", "requests_ins_dep_sup_pro.qty", "products.categories_id")                                                            
                                                                 ->join("products", "requests_ins_dep_sup_pro.products_id", "=", "products.id")
                                                                 ->join("categories", "products.categories_id", "=", "categories.id")
                                                                 ->where('requests_id','=', $value->id)->get();
                            foreach ($requests_idsp as $elem) {                                    
                                $value->qty = $elem->qty;    
                                $value->product = $elem->name;    
                                $value->categories_id = $elem->categories_id;    
                                $value->product_id = $elem->id;  
                                $value->categoryname = $elem->categoryname;        
                            }
                            $value->typerequest = "Trabajo Social";
                        }
                     else {
                            $requests_sp = RequestSupplierProduct::select("requests_suppliersProducts.requests_id", "products.id", "products.name", "categories.name AS categoryname", "requests_suppliersProducts.qty","products.categories_id")
                                                                ->join("suppliers_products", "requests_suppliersProducts.suppliersProducts_id", "=", "suppliers_products.id")
                                                                ->join("products", "suppliers_products.products_id", "=", "products.id")
                                                                ->join("categories", "products.categories_id", "=", "categories.id")
                                                                ->where('requests_id','=', $value->id)->get();

                            foreach ($requests_sp as $elem) {
                                $value->qty = $elem->qty;
                                $value->product = $elem->name;
                                $value->categories_id = $elem->categories_id;
                                $value->product_id = $elem->id;
                                $value->categoryname = $elem->categoryname;
                            }
                            $value->typerequest = $value->type;
                        }

                        $status = Status::find($value->status_id);
                        if ($status !=  null)
                            $value->status = $status->name;

                        $value->number = $count;
                        $count++;
                        $value->actions = '<a class="show" id="show" title="Ver Datos Completos"> <i class="fas fa-eye"></i></a>';
                    }

                    if ($categories_id != null && $categories_id != 0)
                        $requests= $requests->where('categories_id', '=', $categories_id);
                    
                    if ($products_id != null && $products_id != 0)
                        $requests= $requests->where( 'product_id', '=', $products_id);

                    foreach($requests as $element){
                        array_push($dataInformation, $element);
                    }

                    $Products = $requests->groupBy('product')
                                         ->map(function ($row) {
                                            return $row->count();
                                          });

                    $Categories = $requests->groupBy('categoryname')
                                           ->map(function ($row) {
                                                return $row->count();     
                                        });                                   

                    $Areas = $requests->groupBy('area')
                                      ->map(function ($row) {
                                            return $row->count();
                                        });

                    $myArray = json_decode(json_encode($Products), true);
                    $productsNames = array_keys($myArray);
                    $i = 0;
                    foreach($myArray as $elem){
                        array_push($dataProducts, [$productsNames[$i], $elem]);
                        array_push($dataProductsNames, $productsNames[$i]);
                        array_push($dataProductsValues, $elem);
                        array_push($defaultLegend1, ["color" => $this->chartbackgroundColor[$i], "name" => $productsNames[$i], "hover" => $this->charthoverBackgroundColor[$i]]);
                        array_push($defaultbgColor1, $this->chartbackgroundColor[$i]);
                        array_push($defaulthbgColor1, $this->charthoverBackgroundColor[$i]);
                        $i++;
                    }

                    $myArray = json_decode(json_encode($Categories), true);
                    $categoriesNames = array_keys($myArray);
                    $i = 0;
                    foreach($myArray as $elem){
                        array_push($dataCategories, [$categoriesNames[$i], $elem]);
                        array_push($dataCategoriesNames, $categoriesNames[$i]);
                        array_push($dataCategoriesValues, $elem);
                        array_push($defaultLegend2, ["color" => $this->chartbackgroundColor[$i+3], "name" => $categoriesNames[$i], "hover" => $this->charthoverBackgroundColor[$i+3]]);
                        array_push($defaultbgColor2, $this->chartbackgroundColor[$i+3]);
                        array_push($defaulthbgColor2, $this->charthoverBackgroundColor[$i+3]);
                        $i++;
                    }

                    $myArray = json_decode(json_encode($Areas), true);
                    $areasNames = array_keys($myArray);
                    $i = 0;
                    foreach($myArray as $elem){
                        array_push($dataAreas, [$areasNames[$i], $elem]);
                        array_push($dataAreasNames, $areasNames[$i]);
                        array_push($dataAreasValues, $elem);
                        array_push($defaultLegend3, ["color" => $this->chartbackgroundColor[$i+5], "name" =>$areasNames[$i], "hover" => $this->charthoverBackgroundColor[$i+5]]);
                        array_push($defaultbgColor3, $this->chartbackgroundColor[$i+5]);
                        array_push($defaulthbgColor3, $this->charthoverBackgroundColor[$i+5]);
                        $i++;
                    }

                    $information = array(
                        'dataInformation' => $dataInformation,
                        'dataProducts' => $dataProducts,
                        'defaultNames1' => $dataProductsNames,
                        'defaultData1' => $dataProductsValues,
                        'defaultLegend1' => $defaultLegend1,
                        'defaultbgColor1' => $defaultbgColor1,
                        'defaulthbgColor1' => $defaulthbgColor1,
                        'dataCategories' => $dataCategories,
                        'defaultNames2' => $dataCategoriesNames,
                        'defaultData2' => $dataCategoriesValues,
                        'defaultLegend2' => $defaultLegend2,
                        'defaultbgColor2' => $defaultbgColor2,
                        'defaulthbgColor2' => $defaulthbgColor2,
                        'dataAreas' => $dataAreas,
                        'defaultNames3' => $dataAreasNames,
                        'defaultData3' => $dataAreasValues,
                        'defaultLegend3' => $defaultLegend3,
                        'defaultbgColor3' => $defaultbgColor3,
                        'defaulthbgColor3' => $defaulthbgColor3
                    );

                    return $information;
                }
            break;

            default:

            break;

        }

        switch($request->btn){
            case 'PDF':
                $from = $request->from;
                $until = $request->until;
                $type = $request->type;
                $categories_id = $request->categories_id;
                $products_id = $request->products_id;
                $area = $request->area;

                $dataInformation = array();

                if ($from != null && $until != null){
                    $from = New Datetime($from);
                    $until = New Datetime($until);

                    $dateFrom = date_format($from, 'Y-m-d');
                    $dateUntil = date_format($until, 'Y-m-d');
                    $count = 1;

                    if($area != null && $area != "")
                        $requests = Requisition::where('date', '>=', $dateFrom)->where('date', '<=', $dateUntil)->where('area', '=', $area)->where('users_id','=', session ('user_id'))->get();
                    else
                        $requests = Requisition::where('date', '>=', $dateFrom)->where('date', '<=', $dateUntil)->where('users_id','=', session ('user_id'))->get();
                    if($type != null && $type != "0")
                        $requests =  $requests->where('type', '=', $type);

                    foreach ($requests as $value) {
                        $requestPersonalData = RequestPersonalData::where('requests_id', '=', $value->id)->get();
                        foreach ($requestPersonalData as $element) {
                            $personalData = PersonalData::find($element->personalData_id);
                            if ($personalData != null){
                                $addresses = Address::find($personalData->addresses_id);
                                if ($addresses != null){
                                    $community = Community::find($addresses->communities_id);
                                    $municipality = Municipality::find($community->municipalities_id);
                                    $state = State::find($municipality->states_id);
                                    $value->address = $addresses->street.' #'.$addresses->externalNumber.' '.$addresses->internalNumber.' '.$community->name.' ,'.$municipality->name.' ,'.$state->name;
                                    $value->beneficiaries = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                                    $value->beneficiariesCurp = $personalData->curp;
                                }
                            }
                            $extpersonaldata = ExtPersonalData::find($personalData->id);
                            if ($extpersonaldata !=  null)
                                $value->beneficiariesNumber = $extpersonaldata->number;

                            $rpd_disabilities = RPDDisabilities::where('requestsPersonalData_id', '=',$element->id)->get();
                            foreach ($rpd_disabilities as $rpdD) {
                                $disabilityCategory = DisabilityCategories::find($rpdD->disabilitycategories_id);
                                $disability = Disabilities::find($rpdD->disability_id);

                                $value->disabilityCategoryid = $disabilityCategory->id;
                                $value->disabilityCategory = $disabilityCategory->name;
                                $value->disabilityid = $disability->id;
                                $value->disability = $disability->name;

                            }
                            $value->personalData = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                        }

                        if ($value->type == "ts") {
                            $requests_idsp = RequestInsDepSupPro::select("requests_ins_dep_sup_pro.requests_id", "products.id", "products.name", "requests_ins_dep_sup_pro.qty", "products.categories_id")
                                                                ->join("products", "requests_ins_dep_sup_pro.products_id", "=", "products.id")
                                                                ->where('requests_id','=', $value->id)->get();
                            foreach ($requests_idsp as $elem) {
                                $value->qty = $elem->qty;
                                $value->product = $elem->name;
                                $value->categories_id = $elem->categories_id;
                                $value->product_id = $elem->id;
                            }
                            $value->typerequest = "Trabajo Social";
                        }
                        else {                           
                            $requests_sp = RequestSupplierProduct::select("requests_suppliersProducts.requests_id", "products.id", "products.name", "requests_suppliersProducts.qty","products.categories_id")
                                                                ->join("suppliers_products", "requests_suppliersProducts.suppliersProducts_id", "=", "suppliers_products.id")
                                                                ->join("products", "suppliers_products.products_id", "=", "products.id")
                                                                ->join("categories", "products.categories_id", "=", "categories.id")
                                                                ->where('requests_id','=', $value->id)->get();

                            foreach ($requests_sp as $elem) {
                                $value->qty = $elem->qty;
                                $value->product = $elem->name;
                                $value->categories_id = $elem->categories_id;
                                $value->product_id = $elem->id;
                            }
                            $value->typerequest = $value->type;
                        }
                        
                        $status = Status::find($value->status_id);
                        if ($status !=  null)
                            if (session('department_institute_id') <> 4 && ($status->id != 7))
                               $value->status = 'Activa';
                            else
                               $value->status = $status->name;

                        $value->number = $count;
                        $count++;
                        $value->actions = '<a class="show" id="show" title="Ver Datos Completos"> <i class="fas fa-eye"></i></a>';
                    }
                    //dd($requests);
                    if ($categories_id != null && $categories_id != 0)
                         $requests= $requests->where('categories_id', '=', $categories_id);
                    if ($products_id != null && $products_id != 0)
                         $requests= $requests->where( 'product_id', '=', $products_id);

                    foreach($requests as $element){
                        array_push($dataInformation, $element);
                    }

                    $countarray = count($dataInformation) - 1 ;
                    
                    $title1 = 'Reporte de Solicitudes';
                    $title2 = 'del '.$from->format('d-m-Y').' al '.$until->format('d-m-Y');
                    $images_path = public_path('assets/img/');
                    $data = array(
                    
                        'title1' => $title1,
                        'title2' => $title2,
                        'dataInformation' => $dataInformation,
                        'images_path' => $images_path,
                        'count'=>$countarray
                    );
                    //DB::table('Datos')->insert([
                    //]);               
                    
                    
                    $pdf = \PDF::loadView('PDF.reportRequests',  $data);
                    $pdf->setPaper('letter', 'landscape');
                    return $pdf->stream('pdf_file.pdf');
                }
                break;
            case 'excel':
                $from = $request->from;
                $until = $request->until;
                $type = $request->type;
                $categories_id = $request->categories_id;
                $products_id = $request->products_id;
                $area = $request->area;

                $dataInformation = array();

                if ($from != null && $until != null){
                    $from = New Datetime($from);
                    $until = New Datetime($until);

                    $dateFrom = date_format($from, 'Y-m-d');
                    $dateUntil = date_format($until, 'Y-m-d');
                    $count = 1;

                    if($area != null && $area != "")
                        $requests = Requisition::where('date', '>=', $dateFrom)->where('date', '<=', $dateUntil)->where('area', '=', $area)->get();
                    else
                        $requests = Requisition::where('date', '>=', $dateFrom)->where('date', '<=', $dateUntil)->where('users_id','=', session ('user_id'))->get();
                    if($type != null && $type != "0")
                        $requests =  $requests->where('type', '=', $type);

                    foreach ($requests as $value) {
                        $requestPersonalData = RequestPersonalData::where('requests_id', '=', $value->id)->get();
                        foreach ($requestPersonalData as $element) {
                            $personalData = PersonalData::find($element->personalData_id);
                            if ($personalData != null){
                                $addresses = Address::find($personalData->addresses_id);
                                if ($addresses != null){
                                    $community = Community::find($addresses->communities_id);
                                    $municipality = Municipality::find($community->municipalities_id);
                                    $state = State::find($municipality->states_id);
                                    $value->address = $addresses->street.' #'.$addresses->externalNumber.' '.$addresses->internalNumber.' '.$community->name.' ,'.$municipality->name.' ,'.$state->name;
                                    $value->beneficiaries = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                                    $value->beneficiariesCurp = $personalData->curp;
                                }
                            }
                            $extpersonaldata = ExtPersonalData::find($personalData->id);
                            if ($extpersonaldata !=  null)
                                $value->beneficiariesNumber = $extpersonaldata->number;

                            $rpd_disabilities = RPDDisabilities::where('requestsPersonalData_id', '=',$element->id)->get();
                            foreach ($rpd_disabilities as $rpdD) {
                                $disabilityCategory = DisabilityCategories::find($rpdD->disabilitycategories_id);
                                $disability = Disabilities::find($rpdD->disability_id);

                                $value->disabilityCategoryid = $disabilityCategory->id;
                                $value->disabilityCategory = $disabilityCategory->name;
                                $value->disabilityid = $disability->id;
                                $value->disability = $disability->name;

                            }
                            $value->personalData = $personalData->name.' '.$personalData->lastName.' '.$personalData->secondLastName;
                        }

                        if ($value->type == "ts") {
                            $requests_idsp = RequestInsDepSupPro::select("requests_ins_dep_sup_pro.requests_id", "products.id", "products.name", "requests_ins_dep_sup_pro.qty", "products.categories_id")
                                                                ->join("products", "requests_ins_dep_sup_pro.products_id", "=", "products.id")
                                                                ->where('requests_id','=', $value->id)->get();
                            foreach ($requests_idsp as $elem) {
                                $value->qty = $elem->qty;
                                $value->product = $elem->name;
                                $value->categories_id = $elem->categories_id;
                                $value->product_id = $elem->id;
                            }
                            $value->typerequest = "Trabajo Social";
                        }
                        else {
                            $requests_sp = RequestSupplierProduct::select("requests_suppliersProducts.requests_id", "products.id", "products.name", "requests_suppliersProducts.qty","products.categories_id")                                                   
                                                                ->join("suppliers_products", "requests_suppliersProducts.suppliersProducts_id", "=", "suppliers_products.id")
                                                                ->join("products", "suppliers_products.products_id", "=", "products.id")
                                                                ->join("categories", "products.categories_id", "=", "categories.id")
                                                                ->where('requests_id','=', $value->id)->get();

                            foreach ($requests_sp as $elem) {
                                $value->qty = $elem->qty;
                                $value->product = $elem->name;
                                $value->categories_id = $elem->categories_id;
                                $value->product_id = $elem->id;
                            }
                            $value->typerequest = $value->type;
                        }

                        $status = Status::find($value->status_id);
                        if ($status !=  null)
                            if (session('department_institute_id') <> 4 && ($status->id != 7))
                               $value->status = 'Activa';
                            else
                               $value->status = $status->name;

                         // if ($status !=  null)
                         //    $value->status = $status->name;

                        $value->number = $count;
                        $count++;
                    }
                    if ($categories_id != null && $categories_id != 0)
                         $requests= $requests->where('categories_id', '=', $categories_id);
                    if ($products_id != null && $products_id != 0)
                         $requests= $requests->where( 'product_id', '=', $products_id);
                }

                array_push($dataInformation, ['#','Folio', 'Tipo','Fecha','Beneficiario','CURP','Dirección','Teléfono','Apoyo','Cantidad','Área','Estatus']);
                foreach($requests as $element){
                    array_push($dataInformation, [$element->number, $element->folio, $element->typerequest, $element->date, $element->personalData, $element->curpPetitioner, $element->address, $element->beneficiariesNumber, $element->product, $element->qty, $element->area, $element->status]);
                }

                $file = 'RepSolicitudes '.$from->format('Ymd').' - '.$until->format('Ymd').'.xlsx';
                $userExample = new UsersExport([$dataInformation]);
                return Excel::download($userExample, $file);
                break;

            default:
                break;
        }
    }
}
