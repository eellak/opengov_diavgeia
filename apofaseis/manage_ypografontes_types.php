<?php
/*
define(MY_SESSION_VAR_NAME,"_MY_SESSION");

session_start();

// save session variables before destruction by VCL
$_MYSESSION=$_SESSION[MY_SESSION_VAR_NAME];

// provoke the VCL to kill the session
$_GET['restore_session']="1";

// access functions for session variables
function SetSessionVar($aVarName,$aValue) {
$_SESSION[MY_SESSION_VAR_NAME][$aVarName]=$aValue;
}

function GetSessionVar($aVarName) {
return $_SESSION[MY_SESSION_VAR_NAME][$aVarName];
}                                     */

require_once("vcl/vcl.inc.php");


//Includes
require_once("apAuth.php");
require_once("utilClasses.php");
require_once("vcl/vcl.inc.php");
use_unit("menus.inc.php");
use_unit("pager.inc.php");
use_unit("webservices.inc.php");
use_unit("Zend/zacl.inc.php");
use_unit("mysql.inc.php");
use_unit("dbctrls.inc.php");
use_unit("dbgrids.inc.php");
use_unit("db.inc.php");
use_unit("dbtables.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

global $apAuth;
global $aclmanager;

$apAuth->ZAuth->Execute();

$aclmanager->Role = $apAuth->ZAuth->UserRealm;
$apAuth->initUserData();
//if((!($apAuth->ZAuth->UserRealm == 'admin'))AND(!($apAuth->ZAuth->UserRealm == 'admin_foreas')))
if(!($apAuth->ZAuth->UserRealm == 'admin'))
{
   redirect_withdetection("login.php");
}

//$_SESSION[MY_SESSION_VAR_NAME]=$_MYSESSION;

//Class definition
class manage_ypografontes_types extends Page
{
   public $field_servicetype = null;
   public $field_name = null;
   public $Label3 = null;
   public $Pager = null;
   public $Label_searchterms = null;
   public $Button_searchterms = null;
   public $field_searchterms = null;
   public $ID = null;
   public $ypourgeio_table = null;
   public $pb_id = null;
   public $Label8 = null;
   public $pb_id_value_label = null;
   public $field_search_terms = null;
   public $LineLabel = null;
   public $editLabel = null;
   public $EditTable = null;
   public $EditTableDs = null;
   public $LogoutLabel = null;
   public $Label1 = null;
   public $btnUpdate = null;
   public $Label9 = null;
   public $Label17 = null;
   public $lbMessages = null;
   public $btnAdd = null;
   public $Label14 = null;
   public $dsRepeater = null;
   public $Label2 = null;
   public $DBRepeater1 = null;
   public $Panel1 = null;
   public $btnPost = null;
   function btnPostJSMouseUp($sender, $params)
   {

   ?>
   //Add your javascript code here
      document.getElementById('actionSender').value='validate=true';

      return true;

   <?php

   }

   function btnUpdateJSMouseUp($sender, $params)
   {

   ?>
   //Add your javascript code here
       document.getElementById('actionSender').value='validate=true';

      return true;

   <?php

   }





   function ypografontesCSVAddJSClick($sender, $params)
   {

?>
   //Add your javascript code here


<?php

   }






   function manage_ypografontes_typesCreate($sender, $params)
   {

      global $apAuth;
      setlocale(LC_ALL, "el_GR.UTF-8");
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");
      $apAuth->initUserData();

      global $aclmanager;
      $usermessage='<div align="left"><small> <a href="login.php?restore_session=1">ΕΞΟΔΟΣ</a>&nbsp;|&nbsp;<a href="index.php">ΕΠΙΛΟΓΕΣ</a>';
      $usermessage.='&nbsp;|&nbsp;<a href="index.php?restore_session=1">ΑΠΟΣΥΝΔΕΣΗ</a></font>';
      $usermessage .= "<br><STRONG> Χρήστης:</STRONG> ".$apAuth->ZAuth->UserName;


      if($aclmanager->Role == 'admin')
      {
         $usermessage .= "<br><STRONG>Logged in as admin</STRONG>";
         //$this->Label17->Visible = false;
         if (isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms=mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms']=$field_searchterms;
         }

         if (isset($_REQUEST['field_searchterms']) or isset($_SESSION['field_searchterms']) and (!($_REQUEST['field_searchterms']=='') or !($_SESSION['field_searchterms']=='')))
         {
            $apAuth->YpografontesTypesTable->LimitStart=0;
            $apAuth->YpografontesTypesTable->LimitCount=20;
            $apAuth->YpografontesTypesTable->Filter =
            "  name LIKE '%".$_SESSION['field_searchterms']."%' ";
            $this->Pager->current_page=1;
         }
         else
         {
            $apAuth->YpografontesTypesTable->Filter = "";
         }
      }
      
      $usermessage .= "</small></div>";
      $this->Label1->Caption = $usermessage;
      $apAuth->YpografontesTypesTable->Active = false;
      $apAuth->YpografontesTypesTable->Active = true;
      $apAuth->YpografontesTypesTable->refresh();
      if ($apAuth->YpografontesTypesTable->RecordCount==0)
      {
          $this->Pager->DataSource=null;
          $this->Pager->Visible=false;
      }
      else
      {
          $this->Pager->DataSource=$this->dsRepeater;
      }
      $this->EditTable->Active = false;
      $this->EditTable->Active = true;
      $this->EditTable->Refresh();
   }

   function manage_ypografontes_typesJSSubmit($sender, $params)
   {
?>
      msg="";
      result=true;
      //Simple JS validation
     if (document.getElementById('actionSender').value=='validate=true')
     {
     document.getElementById('actionSender').value='';
      if ((document.manage_ypografontes_types.field_name) && (document.manage_ypografontes_types.field_name.value.replace(/^\s+|\s+$/g, '')==""))
      {
        result=false;
        msg+="-Το πεδίο \'Όνομα Τύπου Υπογράφοντα:\' είναι υποχρεωτικό.\n";
      }




      if (!result)
      {
        alert(msg);
		document.getElementById('field_servicetype').focus();
		
      }
      }
      return(result);
<?php
   }

   function Label17JSClick($sender, $params)
   {
?>
    //Add your javascript code here
    return(confirm("Είστε σίγουροι ότι θέλελε να διαγράψετε την εγγραφή?"));
<?php
   }

   function Label17BeforeShow($sender, $params)
   {
      global $apAuth;
      //Setup a link to delete registers
      global $aclmanager;
            $query = "SELECT * FROM ypografontes where type_id='" . $apAuth->YpografontesTypesTable->ID . "' limit 1";
            $apAuth->Query_General2->SQL = $query;
            $apAuth->Query_General2->LimitCount = "-1";
            $apAuth->Query_General2->LimitStart = "-1";
            $apAuth->Query_General2->Prepare();
            $apAuth->Query_General2->close();
            $apAuth->Query_General2->open();

        if ($apAuth->Query_General2->RecordCount==0)
        {
           $this->Label17->Enabled=true;
           $this->Label17->Link = "manage_ypografontes_types.php?action=delete&edit_id=" . md5($apAuth->YpografontesTypesTable->ID);
           $this->Label17->Caption = "[Διαγραφή]";
        }
        else
        {
           $this->Label17->Enabled=false;
           $this->Label17->Link = "";
           $this->Label17->Caption = "";
        }




   }

   function lbMessagesAfterShow($sender, $params)
   {
      //This is a simple message label, so must show and be hidden for next operations
      $sender->Visible = false;
   }

   function btnAddClick($sender, $params)
   {
      //Cancel any pending change
      $this->EditTable->Cancel();

      //Append a new record
      $this->EditTable->Append();

      $this->Label14->Caption = "Δημιουργία νέου Τύπου Υπογράφοντα";
      //Prompt the user for info
      $this->btnPost->Visible = true;
      $this->btnUpdate->Visible = false;
      $this->Panel1->Visible = true;
   }

   function fdClassesBeforeShow($sender, $params)
   {
      global $apAuth;
      global $aclmanager;
      //Before showing the label, set the Link property to the URL we want
      $query = "SELECT ypografontes_types.name as name from ypografontes_types WHERE ypografontes_types.ID='" . $apAuth->YpografontesTypesTable->ID . "'";
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();


      $this->LineLabel->Caption = $apAuth->Query_General->Fields['name'];


      $this->editLabel->Link = "manage_ypografontes_types.php?action=edit&edit_id=" . md5($apAuth->YpografontesTypesTable->ID);
   }

   function Panel1AfterShow($sender, $params)
   {
      //This way, the panel is hidden so it's only shown when editing
      $sender->Visible = false;
   }

   function manage_ypografontes_typesBeforeShow($sender, $params)
   {
      global $apAuth;
      $apAuth->initUserData();
      global $aclmanager;

     /*
      $this->type_id->Clear();
      //$this->field_thematiki_enotita->AddItem('',null,'0');

      if(($aclmanager->Role == 'admin_foreas')or($aclmanager->Role == 'user'))
      {
           if (($apAuth->userData['ypourgeio_table']=='yp_xwris_ypourgeio') or($apAuth->userData['ypourgeio_table']=='foreis_mt'))
           {    //user does NOT belong to a ministry
                $query = "SELECT * from ypografontes_types WHERE NOT servicetype='special' AND servicetype='other' ORDER BY importance ASC;";
           }
           else
           {
                //user belongs to a ministry
                $query = "SELECT * from ypografontes_types WHERE NOT servicetype='special' ORDER BY importance ASC;";
           }

           if ($apAuth->userData['username']=='23290_admin')
           {    //user is specifically: 23290_admin
                $query = "SELECT * from ypografontes_types WHERE type='PM' ORDER BY importance ASC;";
           }
      }
      else
      {    //user is super-admin
           $query = "SELECT * from ypografontes_types ORDER BY importance ASC;";
      }

      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
      {
         $this->type_id->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
         $apAuth->Query_General->next();
      }
      $this->en_energeia->ItemIndex = 1;
      //Get the action to perform
      */


      global $apAuth;
      global $aclmanager;



      $action = $this->input->action;
      if(is_object($action))
      {
         //If there is any edit_id on the input
         $edit_id = $this->input->edit_id;
         if(is_object($edit_id))
         {
            $query = "SELECT * FROM ypografontes_types where MD5(ID)='" . mysql_escape_string($_REQUEST['edit_id']) . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $edit_id->stream['edit_id'] = $apAuth->Query_General->Fields['ID'];
            //Filter the table
            $this->EditTable->Filter = " ID='" . $edit_id->asInteger() . "' ";
            $this->EditTable->Refresh();
            $this->ID->Value=$edit_id->asString();

            //If the user wants to edit a register
            if($action->asString() == 'edit')
            {
               $query = "SELECT * FROM ypografontes_types where ID='" . $edit_id->asInteger() . "'";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();

               $read_servicetype=$apAuth->Query_General->Fields['servicetype'];

               if ($read_servicetype=='ministry') {$this->field_servicetype->ItemIndex=1;};
               if ($read_servicetype=='other') {$this->field_servicetype->ItemIndex=2;};
               if ($read_servicetype=='special') {$this->field_servicetype->ItemIndex=3;};





               $this->Label14->Caption = "Ενημέρωση Τύπου Υπογράφοντα";
               $this->btnPost->Visible = false;
               $this->btnUpdate->Visible = true;
               //Make the panel visible
               $this->Panel1->Visible = true;

            }
            else if($action->asString() == 'delete')
            {
               //Delete the register and refresh the repeater table
               global $apAuth;
               $query = "DELETE FROM ypografontes_types WHERE ID=" . $edit_id->asInteger();
               $apAuth->DB_General->execute($query);
               $apAuth->YpografontesTypesTable->Refresh();
               $this->lbMessages->Caption = "Η εγγραφή διαγράφηκε επιτυχώς";
                echo '<script language="JavaScript" type="text/javascript">
alert("'.$this->lbMessages->Caption.'");
</script>';

            }
         }

      }
   }

   function btnPostClick($sender, $params)
   {
      //Just post the modified contents so get stored
      try
      {

         global $apAuth;
         if (mysql_escape_string($_REQUEST['field_servicetype'])=='1') {$servicetype='ministry';}
         if (mysql_escape_string($_REQUEST['field_servicetype'])=='2') {$servicetype='other';}
         if (mysql_escape_string($_REQUEST['field_servicetype'])=='3') {$servicetype='special';}
         $query =
         "
         INSERT INTO `apofaseis`.`ypografontes_types` (
         `ID` ,
         `type` ,
         `name` ,
         `importance` ,
         `servicetype`
         )
         VALUES (
         NULL ,
         'OTHER',
         '" . mysql_escape_string($_REQUEST['field_name']) . "',
         '99',
         '" . $servicetype . "'
         );
         ";

         $apAuth->DB_General->execute($query);
         $apAuth->YpografontesTypesTable->Refresh();
         $this->lbMessages->Caption = "Η εγγραφή καταχωρήθηκε επιτυχώς";
         $this->lbMessages->Visible = true;

      }
      catch(Exception $e)
      {
         echo $e->getMessage();
         $this->lbMessages->Caption = "Παρουσιάστικε σφάλμα κατά την καταχώριση.";
         $this->lbMessages->Visible = true;
         $this->Panel1->Visible = true;
      }


      echo '<script language="JavaScript" type="text/javascript">
alert("'.$this->lbMessages->Caption.'");
</script>';
   }

   function btnUpdateClick($sender, $params)
   {
      //Just post the modified contents so get stored
      try
      {
         global $apAuth;
         if (mysql_escape_string($_REQUEST['field_servicetype'])=='1') {$servicetype='ministry';}
         if (mysql_escape_string($_REQUEST['field_servicetype'])=='2') {$servicetype='other';}
         if (mysql_escape_string($_REQUEST['field_servicetype'])=='3') {$servicetype='special';}

         $query =
         "update ypografontes_types
         set
         name = '" . mysql_escape_string($_REQUEST['field_name']) . "' ,
         importance = '99' ,
         servicetype = '" . $servicetype . "'
         where ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";

         $apAuth->DB_General->execute($query);
         $apAuth->YpografontesTypesTable->Refresh();
         $this->lbMessages->Caption = "Η εγγραφή ενημερώθηκε επιτυχώς";
         $this->lbMessages->Visible = true;


      }
      catch(Exception $e)
      {
         echo $e->getMessage();
         $this->lbMessages->Caption = "Παρουσιάστικε σφάλμα κατά την ενημέρωση.";
         $this->lbMessages->Visible = true;
         $this->Panel1->Visible = true;
      }


      echo '<script language="JavaScript" type="text/javascript">
alert("'.$this->lbMessages->Caption.'");
</script>';

   }
}

global $application;

global $manage_ypografontes_types;

//Creates the form
$manage_ypografontes_types = new manage_ypografontes_types($application);

//Read from resource file
$manage_ypografontes_types->loadResource(__FILE__);

//Shows the form
$manage_ypografontes_types->show();

?>