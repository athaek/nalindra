<?php include "head.php" ?>
<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="left">
					<label><h3>Laporan Laba Rugi</h3></label>
					<br>
					  <form action="cetak.php" method="post">
							<select name="tgl1" class="leftin1" required="required">
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="12">November</option>
								<option value="12">Desember</option>
							</select>

					  		<input type="submit" class="btnblue" value="Cetak" name="cari">
					  </form>


				</div>
				<div class="both"></div>
			</div>
		</div>
	</div>
</div>
</div>