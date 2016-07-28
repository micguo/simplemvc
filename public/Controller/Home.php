<?php
class HomeController
{
    function indexAction()
    {
        $db = Database::getConnection();

        $sql = "SELECT * FROM User";
        $stat = $db->prepare($sql);
        $stat->execute();

        $rs = $stat->fetchAll(PDO::FETCH_ASSOC);
        print("<pre>");
        print_r($rs);
        print("</pre>");
    }
}