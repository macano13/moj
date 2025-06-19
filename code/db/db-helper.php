<?php

function db_getUserByEmail($email)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_users WHERE email = %s;";
    $query = $db->prepare($sql, $email);
    $result = $db->get_row($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_getUserByEmailAndPwd($email, $pwd)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    // SELECT * FROM tbl_users LEFT JOIN tbl_invoices ON tbl_users.id = tbl_invoices.user_id WHERE tbl_users.id = 2
    $sql = "SELECT tbl_users.id, tbl_users.email, tbl_users.name, tbl_users.password, tbl_users.is_active, tbl_users.user_role, tbl_users.is_deleted, tbl_users.expire_date, tbl_invoices.last_trans_id, tbl_invoices.payment_date FROM tbl_users LEFT JOIN tbl_invoices ON tbl_users.id = tbl_invoices.user_id WHERE email = %s AND password = %s AND is_deleted IS NULL;";
    $query = $db->prepare($sql, $email, $pwd);
    $result = $db->get_row($query);
    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_getUploadsByUserId($user_id, $term, $amount)
{
    $amount != '' ? $amount : 30;

    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_uploads WHERE created_by = %s ";
    if (!empty($term)) {
        $sql .= " AND file_name LIKE %s";
        $query = $db->prepare($sql, $user_id, "%$term%");
    } else {
        // $sql .= "limit 0, $amount";
        $query = $db->prepare($sql, $user_id);
    }
    $result = $db->get_results($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_insertUploadDetails($name, $description, $size, $user_id, $type, $db_name)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "INSERT INTO tbl_uploads (file_name, description,size,creation_date,modified_date,created_by,file_type,db_file_name) VALUES (%s, %s, %s, CURRENT_DATE(),CURRENT_DATE(), %s, %s, %s);";
    $query = $db->prepare($sql, $name, $description, $size, $user_id, $type, $db_name);
    $db->query($query);
    $result = $db->insert_id;
    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_updateSubtitleName($name, $id)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "UPDATE tbl_uploads SET description=%s , modified_date = NOW() WHERE id=%s";
    $query = $db->prepare($sql, $name, $id);

    $db->query($query);
    return $db->rows_affected;
}

function db_insertNewUser($email, $name, $pwd, $is_active)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $curentDate = date("Y-m-d", strtotime(date('Y-m-d') ." -10 days"));

    $sql = "INSERT INTO tbl_users (email, name,password, is_active,user_role,is_deleted,expire_date,reset_token) VALUES (%s, %s, %s, %d, %d, null, %s, %s);";
    $query = $db->prepare($sql, $email, $name, $pwd, $is_active, 2, $curentDate, $reset_token);
    $db->query($query);
    $result = $db->insert_id;
   
    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_getFileNameById($recordid)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT db_file_name FROM tbl_uploads WHERE id = %s;";
    $query = $db->prepare($sql, $recordid);
    $result = $db->get_results($query);

    return json_decode(json_encode($result), true);
}

function db_deleteSubtitleRecord($dId)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "DELETE FROM tbl_uploads WHERE id = %s;";
    $query = $db->prepare($sql, $dId);
    $res = $db->query($query);
    return $res;
}

function db_updateUser($userId, $active, $expireDate)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "UPDATE tbl_users SET is_active=%d, expire_date=%s WHERE id=%d";

    $query = $db->prepare($sql, $active, $expireDate, $userId);

    $db->query($query);

    return $db->rows_affected;
}

function db_checkTransIdExists($transId)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_invoices WHERE last_trans_id = %s";
    $query = $db->prepare($sql,$transId);
    $result = $db->get_results($query);
   
    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_insertInvoicesDetails($userId, $invoiceId, $amount, $transId, $paymentDate)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    if ($transId == '' && $paymentDate == '') {
        $sql = "INSERT INTO tbl_invoices (user_id, invoice_id,amount,invoice_created_date,last_trans_id,payment_date) VALUES (%d, %s, %f, CURRENT_DATE(), null,null);";
        $query = $db->prepare($sql, $userId, $invoiceId, $amount);
    }else{
        $sql = "INSERT INTO tbl_invoices (user_id, invoice_id,amount,invoice_created_date,last_trans_id,payment_date) VALUES (%d, %s, %f, CURRENT_DATE(), %s, %s);";
        $query = $db->prepare($sql, $userId, $invoiceId, $amount, $transId, $paymentDate);
    }
    $db->query($query);
    $result = $db->insert_id;
    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_getUsersList($userId)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_users WHERE is_deleted IS NULL;";
    $query = $db->prepare($sql,'');
    $result = $db->get_results($query);
   
    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_deleteUser($id)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "DELETE FROM tbl_users WHERE id=%s";
    // echo $sql;
    // die;
    $query = $db->prepare($sql, $id);

    $db->query($query);
    return $db->rows_affected;
}
/**
 * 
 *  Status meaning
 * 0 = not active but not suspended
 * 1 = active
 * 2 = suspend
 * 
 */
function db_getUserActiveStatus($id)
{
    $userdb = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

    $usersql = "SELECT is_active FROM tbl_users WHERE id = %s;";
    $userquery = $userdb->prepare($usersql,$id);
    $userStatus = $userdb->get_row($userquery);

    $suspendUser = $userStatus->is_active != 2 ? 2 : 1;

    return $suspendUser;

}

function db_suspendUser($id)
{
    $status = db_getUserActiveStatus($id);

    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "UPDATE tbl_users SET is_active=%d WHERE id=%s";

    $query = $db->prepare($sql, $status, $id);

    $db->query($query);
    return $db->rows_affected;
}

function db_updateCureencyDefault($defaultId, $amount)
{
    
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

    $sql = "UPDATE tbl_payment_amount SET pay_amount=(CASE WHEN id=$defaultId THEN $amount else pay_amount END), default_status = (CASE WHEN id =$defaultId THEN 1 WHEN id != $defaultId THEN 0 END) WHERE 1";

    $query = $db->prepare($sql,'' );

    $db->query($query);
    return $db->rows_affected;
}

function db_payamountList()
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_payment_amount";
    $query = $db->prepare($sql,'');
    $result = $db->get_results($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;    
}

function db_payAmount()
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT currency_name, pay_amount FROM tbl_payment_amount WHERE default_status = 1";
    $query = $db->prepare($sql,'');
    $result = $db->get_row($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_getInvoiceByUser($userId)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_invoices WHERE user_id = $userId ORDER BY id DESC";
    $query = $db->prepare($sql,'');
    $result = $db->get_results($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}
function db_getInvoiceById($invoiceId)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

    $sql = "SELECT tbl_users.email, tbl_users.name, tbl_users.expire_date, tbl_invoices.invoice_id, tbl_invoices.amount, invoice_created_date, tbl_invoices.last_trans_id, tbl_invoices.payment_date FROM tbl_users LEFT JOIN tbl_invoices ON tbl_users.id = tbl_invoices.user_id WHERE tbl_invoices.id =%s";
    $query = $db->prepare($sql,$invoiceId);
    $result = $db->get_results($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_checkInvoiceExistStatus($userId)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_invoices WHERE user_id = %s AND last_trans_id IS NULL;";
    $query = $db->prepare($sql,$userId,'');
    $result = $db->get_results($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;    
}

function getDuePaymentUser($date)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT * FROM tbl_users WHERE expire_date < %s;";
    $query = $db->prepare($sql,$date);
    $result = $db->get_results($query);

    if (APP_DEBUG) {
        $db->dumpvar($result);
    }

    return $result;
}

function db_updateInvoicesDetails($id, $amount, $transId, $paymentDate)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "UPDATE tbl_invoices SET last_trans_id=%s, amount = %f ,payment_date =%s WHERE id=%s";
    $query = $db->prepare($sql, $transId, $amount, $paymentDate, $id);

    $db->query($query);
    return $db->rows_affected;
}

function db_getFileName($createdBy,$fileName)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    if ($createdBy != null) {
        $sql = "SELECT description, file_name FROM tbl_uploads WHERE created_by = %d AND description = %s;";
        $query = $db->prepare($sql,$createdBy, $fileName);
    }else{
        $sql = "SELECT description, file_name FROM tbl_uploads WHERE file_name = %s;";
        $query = $db->prepare($sql,$fileName);

    }
    $result = $db->get_row($query);

    // if (APP_DEBUG) {
    //     $db->dumpvar($result);
    // }
    return $result;
}

function db_getConvertedFileName($createdBy,$fileName)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "SELECT description, file_name FROM tbl_uploads WHERE created_by = %d AND file_name = %s;";
    $query = $db->prepare($sql,$createdBy, $fileName);
    $result = $db->get_row($query);

    return $result;
}
function db_updateSubtitleUpdateTime($userId, $fileName)
{
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    $sql = "UPDATE tbl_uploads SET modified_date = NOW() WHERE file_name=%s AND created_by=%d";
    $query = $db->prepare($sql, $fileName, $userId);

    $db->query($query);
    return $db->rows_affected;
}