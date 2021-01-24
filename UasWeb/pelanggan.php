<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "uas.web";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if(@$_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE pelanggan set
											 	nama = '$_POST[tnama]',
												alamat = '$_POST[talamat]',
											 	kelamin = '$_POST[tkelamin]',
											 	telepon = '$_POST[ttelepon]'
											 WHERE id_pelanggan = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='pelanggan.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='pelanggan.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO pelanggan (nama, alamat, kelamin, telepon)
										  VALUES ( 
										  		 '$_POST[tnama]', 
										  		 '$_POST[talamat]', 
										  		 '$_POST[tkelamin]', 
										  		 '$_POST[ttelepon]'
										  		 )
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='pelanggan.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='pelanggan.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if(@$_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
			
				$vnama = $data['nama'];
				$valamat = $data['alamat'];
				$vkelamin = $data['kelamin'];
				$vtelepon = $data['telepon'];
			}
		}
		else if (@$_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='pelanggan.php';
				     </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<title>Data Bioskop Maccel</title>
</head>
<body style="background-color: #c8d6e5">
<div class="container">

	<h1 class="text-center">DATABASE PELANGGAN</h1>
	<h2 class="text-center">Bioskop Maccel</h2>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Pelanggan
	  </div>
	  <div class="card-body">
	    <form method="post" action="">

	    	<div class="form-group">
	    		<label>Nama</label>
	    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama anda disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Alamat</label>
	    		<textarea class="form-control" name="talamat"  placeholder="Input Alamat anda disini!"><?=@$valamat?></textarea>
	    	</div>
	    	<div class="form-group">
	    		<label>Jenis Kelamin</label>
	    		<select class="form-control" name="tkelamin">
	    			<option value="<?=@$vkelamin?>"><?=@$vkelamin?></option>
	    			<option value="Laki-Laki">Laki-Laki</option>
	    			<option value="Perempuan">Perempuan</option>
	    		</select>
	    	</div>
	    	<div class="form-group">
	    		<label>Telepon</label>
	    		<input type="text" name="ttelepon" value="<?=@$vtelepon?>" class="form-control" placeholder="Input No Telepon anda disini!" required>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Pelanggan
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Nama</th>
	    		<th>Alamat</th>
	    		<th>Kelamin</th>
	    		<th>Telepon</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from pelanggan order by id_pelanggan desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['nama']?></td>
	    		<td><?=$data['alamat']?></td>
	    		<td><?=$data['kelamin']?></td>
	    		<td><?=$data['telepon']?></td>
	    		<td>
	    			<a href="pelanggan.php?hal=edit&id=<?=$data['id_pelanggan']?>" class="btn btn-warning"> Edit </a>
	    			<a href="pelanggan.php?hal=hapus&id=<?=$data['id_pelanggan']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->
<a href="index.php" class="btn btn-outline-primary">Data Karyawan</a>
		<a href="film.php" class="btn btn-outline-primary">Data Film</a>
			<a href="pelanggan.php" class="btn btn-outline-primary">Data Pelanggan</a>
</div>
 <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>