### Export Data To Excel

##### Step 1 : Install Laravel  Project   
~~~
composer create-project --prefer-dist laravel/laravel project_name
~~~

##### Step 2: Install Maatwebsite Package  
~~~
composer require maatwebsite/excel
~~~
config/app.php
~~~
    'providers' => [
        Maatwebsite\Excel\ExcelServiceProvider::class,
    ],
    'aliases' => [
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
    ],
~~~

##### Step 3: Create Dummy Records    
Create 20 Users
~~~
    php artisan tinker
    factory(App\User::class, 20)->create();
~~~

##### Step 4: Add Routes 
routes/web.php
~~~
    Route::get('export', 'MyController@export')->name('export');
    Route::get('importExportView', 'MyController@importExportView');
    Route::post('import', 'MyController@import')->name('import');
~~~
##### Step 5: Create Import Class
~~~
    php artisan make:import UsersImport --model=User
~~~
app/Imports/UsersImport.php
~~~
    <?php
       
    namespace App\Imports;
       
    use App\User;
    use Maatwebsite\Excel\Concerns\ToModel;
    use Maatwebsite\Excel\Concerns\WithHeadingRow;
        
    class UsersImport implements ToModel, WithHeadingRow
    {
        /**
        * @param array $row
        *
        * @return \Illuminate\Database\Eloquent\Model|null
        */
        public function model(array $row)
        {
            return new User([
                'name'     => $row['name'],
                'email'    => $row['email'], 
                'password' => \Hash::make($row['password']),
            ]);
        }
    }
~~~
##### Step 6: Create Export Class
 ~~~
  php artisan make:export UsersExport --model=User
 ~~~
 app/Exports/UsersExport.php
 
 ~~~
 <?php
   
 namespace App\Exports;
   
 use App\User;
 use Maatwebsite\Excel\Concerns\FromCollection;
   
 class UsersExport implements FromCollection
 {
     /**
     * @return \Illuminate\Support\Collection
     */
     public function collection()
     {
         return User::all();
     }
 }
 ~~~  
 
##### Step 7: Create Controller
~~~
php artisan make:controller MyController
~~~
~~~
<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
  
class MyController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
       return view('import');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
        Excel::import(new UsersImport,request()->file('file'));
           
        return back();
    }
}
~~~
#####  Step 8: Create Blade File
  resources/views/import.blade.php
~~~
  <!DOCTYPE html>
  <html>
  <head>
      <title>Laravel 5.8 Import Export Excel to database Example - ItSolutionStuff.com</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  </head>
  <body>
     
  <div class="container">
      <div class="card bg-light mt-3">
          <div class="card-header">
              Laravel 5.8 Import Export Excel to database Example - ItSolutionStuff.com
          </div>
          <div class="card-body">
              <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="file" name="file" class="form-control">
                  <br>
                  <button class="btn btn-success">Import User Data</button>
                  <a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
              </form>
          </div>
      </div>
  </div>
     
  </body>
  </html>
~~~
     
  
   
### Export Data To PDF
~~~
composer require barryvdh/laravel-dompdf
~~~
config/app.php
~~~
'providers' => [
  Barryvdh\DomPDF\ServiceProvider::class,
],
'aliases' => [
  'PDF' => Barryvdh\DomPDF\Facade::class,
]
~~~
pdf.blade.php
~~~
<h1>Customer List</h1>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $customer)
      <tr>
        <td>{{ $customer->id }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->email }}</td>
        <td>{{ $customer->phone }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
~~~
users.blade.php
~~~
@section('content')
<h1>Customer List</h1>
<a href="{{ URL::to('/customers/pdf') }}">Export PDF</a>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $customer)
      <tr>
        <td>{{ $customer->id }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->email }}</td>
        <td>{{ $customer->phone }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
~~~
 function controller
~~~
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;
class CustomerController extends Controller
{
  public function export()
  {
       $filename = 'users.pdf';
       $users = User::get();
       $pdf = PDF::loadView('pdf', compact('users'));
       return $pdf->download($filename);
  }
}
~~~