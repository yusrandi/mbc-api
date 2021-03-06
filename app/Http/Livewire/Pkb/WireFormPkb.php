<?php

namespace App\Http\Livewire\Pkb;

use App\Models\Hasil;
use App\Models\Laporan;
use App\Models\Metode;
use App\Models\PeriksaKebuntingan;
use App\Models\Peternak;
use App\Models\PeternakSapi;
use App\Models\Sapi;
use App\Models\Upah;
use Intervention\Image\ImageManager;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;


class WireFormPkb extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $foto, $selectedItemId, $metode_id, $hasil_id, $sapi_id, $waktu_pk, $status , $reproduksi;
    public $query, $search_results, $how_many, $sapiEartag = '';

    protected $rules = [
        'metode_id' => 'required',
        'hasil_id' => 'required',
        'sapi_id' => 'required',
        'foto' => 'required',
        'status' => 'required',
        'reproduksi' => 'required',
    ];
    protected $messages = [
        
        'metode_id.required' => 'this field is required.',  
        'hasil_id.required' => 'this field is required.',  
        'sapi_id.required' => 'this Sapi ID is required.',  
    ];

    protected $listeners = [
        'cleanVars',
        'getModelId',
        'forceCloseModal',
    ];

    public function updatedQuery() {
        // dd($this->dataSapi());
        $this->search_results = $this->dataSapi()
            ->take($this->how_many);
    }

    public function loadMore() {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }
    public function selectSapi($sapiId) {
        $sapi = Sapi::find($sapiId);
        $this->sapi_id = $sapi->id;
        $this->sapiEartag = 'MBC-' . $sapi->generasi . '.' . $sapi->anak_ke . '-' . $sapi->eartag_induk . '-' . $sapi->eartag;
        // dd($sapiId);
        
    }
    public function dataSapi()
    {
       
        $sapi =  Sapi::orderBy('generasi')
        ->where('kondisi_lahir' ,'!=', 'Mati')
        ->where('eartag', 'like', '%' . $this->query . '%')
        ->orWhere('generasi', 'like', '%' . $this->query . '%')
        ->orWhere('nama_sapi', 'like', '%' . $this->query . '%')
        ->get();

        // dd(count($sapi));

        $data = Collection::empty();
        foreach ($sapi as $key => $value) {
            if ($value->kondisi_lahir != 'Mati') {
                if ($value->panens->last() != null) {
                    if ($value->panens->last()->role != 1) {
                        $data->push($value);  
                    }
                }else {
                    $data->push($value);  
                }
            }
            
            
        }

        return $data;
    }

    public function resultData()
    {
       
        $sapi =  Sapi::orderBy('generasi')
        ->where('kondisi_lahir' ,'!=', 'Mati')
        ->get();

        $data = [];
        foreach ($sapi as $key => $value) {
            if ($value->panens->last() != null) {
                if ($value->panens->last()->role != 1) {
                    array_push($data, $value);   
                }
            }else {
                array_push($data, $value);
                
            }
            
        }

        return $data;
    }


    public function render()
    {
        
        return view('livewire.pkb.wire-form-pkb',[
            'metodes' => Metode::orderBy('metode','ASC')->get(),
            'hasils' => Hasil::orderBy('hasil','ASC')->get(),
            'sapis' => $this->resultData(),
        ]);
    }

    public function mount()
    {
        date_default_timezone_set("Asia/Makassar");
        $today = date('Y/m/d');
        $this->waktu_pk = $today;
        $this->status = true;
        $this->reproduksi = true;

        // dd($this->status);
    }

    public function save(){

        // dd($this->status);
        date_default_timezone_set("Asia/Makassar");
        $today = date('Y/m/d');

        $validateData = [];
        $validateData = array_merge($validateData,[
            'sapi_id' => 'required',
            'metode_id' => 'required',
            'hasil_id' => 'required',
            'status' => 'required',
            'reproduksi' => 'required',
        ]);

        if (!$this->selectedItemId) {
            $validateData = array_merge($validateData,[
                'foto' => 'required|image|max:1024',
            ]);
        }
        

        $data = $this->validate($validateData);

        $sapi = Sapi::find($this->sapi_id);
        $peternak = Peternak::find($sapi->peternak_id);

        $res_foto = $this->foto;
        if (!empty($res_foto)){
            $validateData = array_merge($validateData,[
                'foto' => 'required|image|max:1024',
            ]);
            
            $data['foto'] = $this->handleImageIntervention($res_foto);
        }

        $data['peternak_id'] = $peternak->id;
        $data['pendamping_id'] = $peternak->pendamping_id;
        $data['tsr_id'] = $peternak->pendamping->tsr_id;

        $data['waktu_pk'] = $today;

        $save = $this->selectedItemId ? PeriksaKebuntingan::find($this->selectedItemId)->update($data) : PeriksaKebuntingan::create($data);
        $save ? $this->isSuccess("Data Berhasil Tersimpan") : $this->isError("Data Gagal Tersimpan");
        $upah = Upah::find(1);
        Laporan::create([
           'sapi_id' => $this->sapi_id,
           'peternak_id' => $data['peternak_id'], 
           'pendamping_id' => $data['pendamping_id'], 
           'tsr_id' => $data['tsr_id'], 
           'tanggal' => $today, 
           'perlakuan' => $upah->detail,
           'upah' => $upah->price,
        ]);
        
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModalAdd');
        $this->cleanVars();  

    }

    public function getModelId($modelId)
     {
        $this->selectedItemId = $modelId;
        $data = PeriksaKebuntingan::find($modelId);
       $this->metode_id = $data->metode_id;
       $this->hasil_id = $data->hasil_id;
       $this->sapi_id = $data->sapi_id;
       $this->waktu_pk = $data->waktu_pk;
       $this->status = $data->status;
       $this->reproduksi = $data->reproduksi;

       $sapi = Sapi::find($this->sapi_id);
       $this->sapiEartag = 'MBC-' . $sapi->generasi . '.' . $sapi->anak_ke . '-' . $sapi->eartag_induk . '-' . $sapi->eartag;
      

     }

    public function cleanVars()
    {
       $this->selectedItemId = null;
       $this->foto = null;
       $this->metode_id = null;
       $this->hasil_id = null;
       $this->sapi_id = null;
       $this->waktu_pk = null;
       $this->sapiEartag = null;

    //    $this->status = null;
    }
   
   public function forceCloseModal()
    {
        $this->cleanVars();
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function handleImageIntervention($res_foto)
    {
        $res_foto->store('public/photos');
        $imageName = $res_foto->hashName();
        $data['foto'] = $imageName;

        $manager = new ImageManager();
        $image = $manager->make('storage/photos/'.$imageName)->resize(500,300);
        $image->save('storage/photos_thumb/'.$imageName);

        return $imageName;
    }

    public function triggerConfirm()
    {
        $this->confirm('yakin akan menghapus data ?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'showCancelButton' =>  true, 
            'onConfirmed' => 'delete',
            'onCancelled' => 'cancelled'
        ]);
    }

    public function isSuccess($msg)
    {
        $this->alert('success', $msg, [
            'position' =>  'top-end', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Cancel', 
            'showCancelButton' =>  false, 
            'showConfirmButton' =>  false, 
      ]);
    }
    public function isError($msg)
    {
        $this->alert('error', $msg, [
            'position' =>  'top-end', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Cancel', 
            'showCancelButton' =>  false, 
            'showConfirmButton' =>  false, 
      ]);
    }
    public function confirmed()
    {
        // Example code inside confirmed callback
    
        $this->alert('success', 'Hello World!', [
            'position' =>  'top-end', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Cancel', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  true, 
      ]);
    }
    
    public function cancelled()
    {
        // Example code inside cancelled callback
    
        $this->alert('info', 'Understood');
    }

}
