const aksi = $('.flash-data').data('aksi');
const halaman = $('.flash-data').data('halaman');
const title = $('.flash-data').data('title');

if((title=="Berhasil"&&aksi==
"Registrasi")){
Swal.fire({
icon: 'success',
title: title,
text: 'Melakukan '+aksi,
})
}else if(title=="Gagal"&&aksi=="Login"){
Swal.fire({
icon:'error',
title: title,
text: 'Melakukan '+aksi
})
}else
if((title=="Berhasil")&&(aksi=="Menambahkan"||aksi=="Menghapus"||aksi=="Mengupdate"||aksi=="Dimasukkan"||aksi=="Dikeluarkan")){
Swal.fire({
icon: 'success',
title: title,
text: aksi+' '+halaman,
})
}else if(title=="Gagal"&&aksi=="Menambahkan"){
Swal.fire({
icon:'error',
title: title,
text: aksi+' '+halaman,
})
}else if(title == "Stok Produk Habis"){
Swal.fire({
icon:'error',
title: "Gagal",
text: title,
})
}else if((title=="Gagal")&&(aksi=="Produk Sudah Di Keranjang")){
Swal.fire({
icon:'error',
title: "Gagal",
text: aksi,
})
}
