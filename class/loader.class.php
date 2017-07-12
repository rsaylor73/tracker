<?php
include PATH."/class/projects.class.php";

/* This is the first class in the chain */

class loader extends projects_functions {

    public $linkID;
    function __construct($linkID){ $this->linkID = $linkID; }

    /* The load_module function performs the routing of functions */

    public function load_module($module) {
        if (method_exists('loader',$module)) {
            $this->$module();
        } elseif (method_exists('projects_functions',$module)) {
            $this->$module();
        } elseif (method_exists('reports_functions',$module)) {
            $this->$module();
        } elseif (method_exists('review_functions',$module)) {
            $this->$module();
        } elseif (method_exists('admin_functions',$module)) {
            $this->$module();
        } elseif (method_exists('users_functions',$module)) {
            $this->$module();
        } elseif (method_exists('common_functions',$module)) {
            $this->$module();
        } elseif (method_exists('JWT',$module)) {
            $this->$module();
        } elseif (method_exists('core',$module)) {
            $this->$module();
        } else {
            print "<br><font color=red>The $module method does not exist.</font><br>";
            die;
        }
    } // public function load_module($module)

    public function load_smarty($vars,$template,$dir='') {
        // loads the PHP Smarty class
        require_once(PATH.'/libs/Smarty.class.php');
        $smarty=new Smarty();
        $smarty->setTemplateDir(PATH.'/templates/'.$dir);
        $smarty->setCompileDir(PATH.'/templates_c/');
        $smarty->setConfigDir(PATH.'/configs/');
        $smarty->setCacheDir(PATH.'/cache/');
        if (is_array($vars)) {
            foreach ($vars as $key=>$value) {
                $smarty->assign($key,$value);
            }
        }
        $smarty->display($template);
    }

    /* This is used with the page numbers in the admin */
    public function map_numbers($max,$pages) {
        for ($i=0; $i < $pages; $i++) {
            if ($stop == "") {
                $stop = "0";
            }
            if ($i > 0) {
                $stop = $stop + $max;
            }
            $i2 = $i + 1;
            $array[$i2] = $stop;
        }
        return $array;
    }

    /* This is used with the page numbers in the admin */
        public function page_numbers($sql,$url) {
                $max = "20";
                $result = $this->new_mysql($sql);
                $total_records = $result->num_rows;
                $total_records = $total_records / $max;
                $pages = ceil($total_records);

                        $page = $_GET['page'];
                        if ($page == "") {
                                $page = "1";
                        }

                        $html = "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
                        $html .= "<button type=\"button\" class=\"btn btn-default\" disabled>Page</button>";
                        if ($page == "1") {
                                $html .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"document.location.href='".$url.$page."/0'\">1</button>";
                                $array = $this->map_numbers($max,$pages);
                                $next = $page + 1;
                                $next10 = $page + 10;
                                $next100 = $page + 100;

                                if ($next < $pages) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next."/".$array[$next]."'\">&gt;&gt;</button>";
                                }

                                if ($next10 < $pages) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next10."/".$array[$next10]."'\">+ 10</button>";
                                }

                                if ($next100 < $pages) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next100."/".$array[$next100]."'\">+ 100</button>";
                                }

                                $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pages."/".$array[$pages]."'\">$pages</button>";

                        } else {
                                $array = $this->map_numbers($max,$pages);

                                $pre = $page - 1;
                                $pre10 = $page - 10;
                                $pre100 = $page - 100;
                                $next = $page + 1;
                                $next10 = $page + 10;
                                $next100 = $page + 100;

                                $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url."1/0'\">1</button>";

                                if ($pre10 > 0) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pre10."/$array[$pre10]'\">- 10</button>";
                                }

                                if ($pre100 > 0) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pre100."/$array[$pre100]'\">- 100</button>";
                                }

                                $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pre."/$array[$pre]'\">&lt;&lt;</button>";

                                $html .= "<button type=\"button\" class=\"btn btn-primary\" onclick=\"document.location.href='".$url.$page."/$array[$page]'\">$page</button>";

                                if ($next < $pages) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next."/$array[$next]'\">&gt;&gt;</button>";
                                }

                                if ($next10 < $pages) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next10."/$array[$next10]'\">+ 10</button>";
                                }

                                if ($next100 < $pages) {
                                        $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$next100."/$array[$next100]'\">+ 100</button>";
                                }

                                $html .= "<button type=\"button\" class=\"btn btn-default\" onclick=\"document.location.href='".$url.$pages."/$array[$pages]'\">$pages</button>";

                        }
                        $html .= "</div>";
                return $html;
        }

    

} // class loader extends projects
?>