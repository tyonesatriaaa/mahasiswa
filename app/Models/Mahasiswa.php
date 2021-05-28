<?php
namespace App\Models; 
    // use Illuminate\Contracts\Auth\MustVerifyEmail; 
    use Illuminate\Database\Eloquent\Factories\HasFactory; 
    // use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable; 
    // use Illuminate\Notifications\Notifiable; 
    use Illuminate\Database\Eloquent\Model; //Model Eloquent 
    use App\Models\Mahasiswa;

class Mahasiswa extends Model //Definisi Model 
{ 
    protected $table="mahasiswa"; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswas 
    // public $timestamps= false; 
    protected $primaryKey = 'Nim'; // Memanggil isi DB Dengan primarykey 
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    /** 
     * The attributes that are mass assignable. 
     * 
     *  @var array 
     */ 
    protected $fillable = [ 
        'Nim', 
        'Nama', 
        'Kelas_id', 
        'Jurusan', 
        'No_Handphone',
        'email',
        'tgl_lahir'

    ]; 

    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }
};