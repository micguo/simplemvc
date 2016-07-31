<?php
class FormSearch extends FormBase
{
    function __construct()
    {
        $this->templateFile = "Form/Search";
    }

    /**
     * Form validate process
     * @return void
     */
    protected function validate()
    {
        
    }

    /**
     * Form submit process
     * @return void
     */
    protected function submit()
    {
        $rs = User::search($this->formValue['keyword']);

        if (!empty($rs)) {
            $out = "";
            $out .= "<b>Search Result:</b>";
            // @todo, turn this into template
            $out .= "<table border=\"1\">";
            foreach ($rs as $row) {
                $out .="<tr>";
                $out .="<td>" . $row['Name'] . "</td>";
                $out .="<td>" . $row['Email'] . "</td>";
                $out .="</tr>";
            }
            $out .= "</table>";
        } else {
            $out = "No result.";
        }
        $this->formValue['searchResult'] = $out;
    }
}