<?php 
$form = Loader::helper('form');
defined('C5_EXECUTE') or die("Access Denied.");
if (isset($response)) { ?>
	<?php echo $response?>
<?php  } ?>

<script type="text/javascript">

$(document).ready(function() {
	$('#iama').change(function(){
		if ($('#iama').val() == "reseller")
		{
			$('#reseller').css('display', 'inline');
		}
		else
		{
			$('#reseller').css('display', 'none');
		}
	});
});

</script> 
 
<style>
	.error {
	    color: red;
	    display: block;
	}
	.full {
	    border:1px solid #641f1a;color:#641f1a;background:#ffd2d4 no-repeat; background-position:30px 20px;
			margin:20px 5px 5px 80px;padding:10px; font-size:16px;
	}
</style>
<?php 
$db = new PDO('mysql:host=localhost;dbname=x', 'x', 'x');
if ( !$db )
{
	die('Could not connect: ' . mysql_error());
}
$stmt = $db->query("SELECT * FROM ucm_signup");
$row_count = $stmt->rowCount();

if($row_count < 500) { ?>

<form name="contact_form" method="post" action="http://x.com/ex_mailer.php">

	<table border="0">
		<tr>
			<td style="width: 150px">Nom de l'entreprise *:</td>
			<td colspan="2"><input id="company" name="company" type="text" size="40" style="width: 211px"/></td>
			</tr>
		<tr>
			<td>Adresse 1 *:</td>
			<td colspan="2"><input id="address1" name="address1" type="text" size="40" style="width: 211px"/></td>
		</tr>
		<tr>
			<td>Adresse 2 :</td>
			<td colspan="2"><input id="address2" name="address2" type="text" size="40" style="width: 211px"/></td>
		</tr>
		<tr>
			<td>Ville *:</td>
			<td colspan="2"><input id="city" name="city" type="text" size="30" style="width: 211px"/></td>
		</tr>
		<tr>
			<td>Province *:</td>
			<td colspan="2"><input id="province" name="province" type="text" size="30" style="width: 211px"/></td>
		</tr> 
		<tr>
			<td>Code postal *:</td>
			<td colspan="2"><input id="zip" name="zip" type="text" size="12" style="width: 211px"/></td>
		</tr> 
		<tr>
			<td style="width: 150px" >Prénom *:</td>
			<td colspan="2"><input id="fname" name="fname" type="text" size="30" /></td>
		</tr>
		<tr>
			<td>Nom de famille*:</td>
			<td colspan="2"><input id="lname" name="lname" type="text" size="30" /></td>
		</tr>
		<tr>
			<td>Courriel *:</td>
			<td colspan="2"><input id="email" type="text" name="email" size="30" /></td>
		</tr>
		<tr>
			<td>Numéro de téléphone *:</td>
			<td colspan="2"><input id="phone" name="phone" type="text" size="30" /></td>
		</tr>  
		<tr>
			<td>Session *:</td>
			<td>
				<div>
					<select id="session" name="session" style="width: 216px" size="1"> 
						<option value="Please Select a Session" > </option>
						<option value="Intro" >L’introduction des produits seulement</option>
						<option value="TechTr" >La formation technique seulement</option>
						<option value="IntroTechTr" >L’introduction des produits et la formation technique</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Je suis un *:</td>
			<td>
				<div>
					<select id="iama" name="iama" style="width: 216px" size="1"> 
						<option value="" selected="selected"></option>
						<option value="reseller" >Revendeur</option>
						<option value="distributor" >Distributeur</option>
						<option value="technologypartner" >Partenaire technologique</option>
						<option value="itprofessional" >Professionnel de l'informatique</option>
						<option value="interestedprofessional" >Professionnel intéressé</option>
						<option value="other" >Autre</option>
					</select>
				</div>
			</td>
		</tr>
		</table>
		<table id="reseller" style="display:none;" border="0">
		<tr>
			<td style="width: 150px">Votre fournisseur? *</td>
			<td colspan="2"><input id="buyfrom" name="buyfrom" type="text" size="30" /></td>
		</tr>
		</table>
		<table>
		<tr>
			<td style="width: 200px">* = Informations obligatoires</td>
		</tr>
		
	</table>

	<table>
		<tr>
			<td align="left"><input type="reset" name="reset" value="Remettre"/></td>
			<td style="width: 211px"></td>
			<td align="right"><input type="submit" name="Submit" value="Soumettre" id="btn-submit"></td>
			</tr>
	</table>
</form>
<?php  } 
	else { ?>
	<table border="0">
		<tr>
		<td><br/> </td>
		</tr>
		<tr>
			<td><span class="full">Registration Closed</span></td>
		</tr>
	</table>
</form>	
<?php  } ?>
<div id="errors"></div>

<script type="text/javascript">
	$('#btn-submit').click(function() {
		$('.error').hide();
		
		var hasError = false;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		var datePattern = /^((0[1-9])|(1[0-2]))\/((20[1-4][0-9]))$/;

	//validate company name
    if (($("#company").val() == '')) {
      $("#errors").after('<span class="error"Entrez le nom de votre entreprise </span>');
      hasError = true;
    }

  //validate address1
    if (($("#address1").val() == '')) {
      $("#errors").after('<span class="error">Entrez votre adresse.</span>');
      hasError = true;
    }

  //validate city
    if (($("#city").val() == '')) {
      $("#errors").after('<span class="error">Entrez le nom de votre ville.</span>');
      hasError = true;
    }

  //validate province
    if (($("#province").val() == '')) {
      $("#errors").after('<span class="error">Entrez le nom de votre province.</span>');
      hasError = true;
    }

  //validate zip
    if (($("#zip").val() == '')) {
      $("#errors").after('<span class="error">Entrez votre code postal.</span>');
      hasError = true;
    }
	
    //validate name
    if (($("#fname").val() == '') || ($("#lname").val() == '')) {
      $("#errors").after('<span class="error">Entrez votre nom complet.</span>');
      hasError = true;
    }
    
    //validate email
    var emailaddressVal = $("#email").val();
    if(emailaddressVal == '') {
      $("#errors").after('<span class="error">Entrez une adresse courriel valide.</span>');
      hasError = true;
    }
    else if(!emailReg.test(emailaddressVal)) {
      $("#errors").after('<span class="error">Entrez Prénom.</span>');
      hasError = true;
    }

    //validate phone number
    if (($("#phone").val() == '')) {
      $("#errors").after('<span class="error">Entrez votre numéro de téléphone.</span>');
      hasError = true;
    }

    //validate session
    if (($("#session").val() == 'Please Select a Session')) {
      $("#errors").after('<span class="error">Sélectionnez une session.</span>');
      hasError = true;
    }
    
    //validate I ama
    if ( ($("#iama").val() == '') ) {
      $("#errors").after('<span class="error">Sélectionnez un choix \'Je suis\'.</span>');
      hasError = true;
    }
    // validate buying from
    if ( ($("#buyfrom").val() == '') && ($("#iama").val() == 'reseller')) {
        $("#errors").after('<span class="error">Entrez votre fournisseur.</span>');
        hasError = true;
      }
    
    if(hasError == true) { return false; }
	
	});
		
</script>

