<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = []; //TAMBAHKAN LINE INI
    protected $appends = ['status_label','tgl_transaksi']; //APPEND ACCESSORNYA AGAR DITAMPILKAN DIJSON YANG DIRETURN

    public function detail()
    {
        //TRANSAKSI KE DETAIL MENGGUNAKAN RELASI ONE TO MANY
        return $this->hasMany(DetailTransaction::class);
    }

    public function customer()
    {
        //TRANSAKSI KE CUSTOMER MELAKUKAN REFLEK DATA TERKAIT MENGGUAKAN BELONGSTO
        return $this->belongsTo(Customer::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    //INI ADALAH ACCESSOR UNTUK CUSTOM FIELD STATUS YANG AKAN DIAPPEND KE JSON
    public function getStatusLabelAttribute()
    {
        //JIKA STATUS NYA 1 
        if ($this->status == 1) {
            //MAKA VALUENYA ADALAH HTML YANG BERISI LABEL SUCCESS
            return '<span class="badge badge-success">Selesai</span>';
        }
        //SELAIN ITU MENAMPILKAN LABEL PRIMARY
        return '<span class="badge badge-primary">Proses</span>';
    }

    //KITA BUAT ATTRIBUTE BARU UNTUK TglTransaksi
    public function getTglTransaksiAttribute()
    {
        //ISINYA ADALAH created_at REFORMAT SESUAI TANGGAL INDONESIA
        return $this->created_at->format('d-m-Y H:i:s');
    }

    //BUAT RELASI ANTARA USER DAN TRANSACTION
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
