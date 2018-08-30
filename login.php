<center>
<form name="logForm" method="post" action="?open=Login-Validasi">
  <table class="table-list" width="500" border="0" cellpadding="2" cellspacing="1">
    <tr>
      <td width="106" rowspan="5" align="center" bgcolor="#CCCCCC"><img src="images/login-key.png" width="116" height="75" /></td>
      <th colspan="2"><b>LOGIN </b></td>    </tr>
    <tr>
      <td width="120"><b>Username</b></td>
      <td width="250"><b>: 
        <input name="txtUser" type="text" size="30" maxlength="20" />
      </b></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>: 
        <input name="txtPassword" type="password" size="30" maxlength="20" />
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><strong>Level</strong></td>
      <td bgcolor="#FFFFFF"><strong>: </strong><b>
        <select name="cmbLevel">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Pengajaran", "Kasir", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnLogin" value=" Login " /></td>
      </tr>
  </table>
  <p><strong>LOGIN ADMIN</strong></p>
  <ul>
    <li>Username : admin</li>
    <li>Password : admin</li>
    <li>Level Akses : admin    </li>
  </ul>
</form>
</center>
