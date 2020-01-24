<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use DateTime;
    use DB;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    use App\Lot;
    use App\monthExpense;
    use App\categoryExpense;
    class Controller extends BaseController
    {   use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        public function index(){
            $lots = DB::table('csv_data')->get();
            $lotList = array();
            $monthlyExpenseList=array();
            $categoryExpenseList=array();

            foreach($lots as $lot){
                //Push the lotList array in lotList
                $newLot = new Lot($lot->date,$lot->category,$lot->lot_title,$lot->lot_location,$lot->lot_condition,$lot->pre_tax_amount,$lot->tax_name,$lot->tax_amount);
                array_push($lotList, $newLot);
                $str_arr = explode ("/", $lot->date);
                $deciderMonthlyExpense = true;
                $deciderCategoryExpense = true;
                foreach( $monthlyExpenseList as $monthlyExpense){
                    if($monthlyExpense->getMonthAndYear()==$str_arr[0]."/".$str_arr[2]){
                        $deciderMonthlyExpense=false; 
                        $indexForMonthlyExpense = array_search( $monthlyExpense,$monthlyExpenseList);
                        
                    }
                }
                //Set monthtly expense list, if it's not in list pushed
                if( $deciderMonthlyExpense )
                {
                    $monthlyExpenseObject=new monthExpense($str_arr[0]."/".$str_arr[2],$lot->pre_tax_amount+$lot->tax_amount);
                    array_push( $monthlyExpenseList,$monthlyExpenseObject);
                }
                //Else update the expense.
                else{
                    
                    $monthlyExpenseList[$indexForMonthlyExpense ]= new monthExpense($str_arr[0]."/".$str_arr[2],$monthlyExpenseList[$indexForMonthlyExpense]->getExpense()+$lot->pre_tax_amount+$lot->tax_amount);; 
                    
                }

                foreach( $categoryExpenseList as $categoryExpense){
                    if($categoryExpense->getCateogry()==$lot->category){
                        $deciderCategoryExpense=false; 
                        $indexForCategoryExpense = array_search( $categoryExpense,$categoryExpenseList);
                        
                    }
                }
                 //Set cetegory expense list, if it's not in list pushed
                if($deciderCategoryExpense)
                {
                    $categoryExpenseObject=new categoryExpense($lot->category,$lot->pre_tax_amount+$lot->tax_amount);
                    array_push( $categoryExpenseList, $categoryExpenseObject);
                }
                else{
                    
                    $categoryExpenseList[$indexForCategoryExpense]= new categoryExpense($lot->category,$categoryExpenseList[$indexForCategoryExpense]->getExpense()+$lot->pre_tax_amount+$lot->tax_amount);; 
                    
                }

            }
            return view('welcome', ['lots' =>  $lotList,'monthExpense'=>$monthlyExpenseList,'categoryExpense'=> $categoryExpenseList]);


        }
        public function csvfileupload(Request $request)
        { 
            $ifsuccess=true  ;
            if ( $file = $request->file('csvfile')) {
                $path = $request->file('csvfile')->getRealPath();
                // File Details 
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $tempPath = $file->getRealPath();
                $fileSize = $file->getSize();
                $mimeType = $file->getMimeType();
                $file->move("uploads",$filename);
                $filepath = public_path("uploads/".$filename);
                //Read File
                $file = fopen($filepath,"r");
                //Build the Array
                $importData_arr = array();
                $index=0;
                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($filedata );
                    if($index>0)
                    {
                        for ($c=0; $c < $num; $c++) {
                            $importData_arr[$index][] = $filedata [$c];
                        }
                    }
                    $index++;
                }
                foreach($importData_arr as $importData){
                //Usage of the Model here
                    $Object = new Lot($importData[0],$importData[1],$importData[2],$importData[3],$importData[4],$importData[5],$importData[6],$importData[7]);
                    $insertData = array(
                        "date"=>$Object->getDate(),
                        "category"=>$Object->getCategory(),
                        "lot_title"=>$Object->getLotTitle(),
                        "lot_location"=>$Object->getlotLocation(),
                        "lot_condition"=>$Object->getCondition(),
                        "pre_tax_amount"=>$Object->getPre_taxAmount(),
                        "tax_name"=>$Object->getTax_Name(),
                        "tax_amount"=>$Object->getTaxAmount()
                    );
                    //Check if the record existed before
                    $value=DB::table('csv_data')->where([
                        "date"=>$Object->getDate(),
                        "category"=>$Object->getCategory(),
                        "lot_title"=>$Object->getLotTitle(),
                        "lot_location"=>$Object->getlotLocation(),
                        "lot_condition"=>$Object->getCondition(),
                        "pre_tax_amount"=>$Object->getPre_taxAmount(),
                        "tax_name"=>$Object->getTax_Name(),
                        "tax_amount"=>$Object->getTaxAmount()
                    ])->get();
                    // 
                    if($value->count() == 0){
                    DB::table('csv_data')->insert($insertData);
                    }
                    else{
                        return response()->json(['success'=>"The file already existed"]);
                        $ifsuccess=false;
                        break;
                    }
                

                }
                
                if($ifsuccess){
                    return response()->json(['success'=>'Ok, successfully upload to database!']);

                }
                fclose($file);
                
            }
    
    }
    }
