<?php
class pluginUninstaller extends Plugin{
    public function init(){
        $this->formButtons = false;
    }
    
    public function post(){
        if(isset($_POST['uninstall'])){
            $path = PATH_PLUGINS.$_POST['uninstall'];
            Filesystem::deleteRecursive($path);
        }
    }
    
    public function form(){
        global $L;
        $html  = '<div class="alert alert-primary" role="alert">'.$this->description().'</div>
        <div class="alert alert-primary" role="alert"><strong>Info: </strong> This plugin requires JS to be enabled</div>
        <input type="text" class="light-table-filter" data-table="order-table" placeholder="Search for anything..">
        <script>"use strict"; var LightTableFilter=function (Arr){var filterInput; function _onInputEvent(e){filterInput=e.target; var tables=document.getElementsByClassName(filterInput.getAttribute("data-table")); Arr.forEach.call(tables, function (table){Arr.forEach.call(table.tBodies, function (tbody){Arr.forEach.call(tbody.rows, _filter);});});}function _filter(row){var text=row.textContent.toLowerCase(), val=filterInput.value.toLowerCase(); row.style.display=text.indexOf(val)===-1 ? "none" : "table-row";}return{init: function init(){var inputs=document.getElementsByClassName("light-table-filter"); Arr.forEach.call(inputs, function (input){input.oninput=_onInputEvent;});}};}(Array.prototype); document.addEventListener("readystatechange", function (){if (document.readyState==="complete"){LightTableFilter.init();}}); </script>
        <table class="table mt-3 order-table"><thead><tr>
        <th class="border-bottom-0" scope="col">Name</th>
        <th class="border-bottom-0" scope="col">Action</th>
        </tr></thead><tbody>';
        
        $installedPlugins = glob(PATH_PLUGINS . '/*' , GLOB_ONLYDIR);
        foreach($installedPlugins as $installedPlugin){
            $installedPlugin = str_replace(PATH_PLUGINS.'/', '', $installedPlugin);
            $html .= '<tr><td>'.$installedPlugin.'</td><td><button name="uninstall" class="btn btn-danger my-2" type="submit" value="'.$installedPlugin.'">Uninstall</button></td></tr>';
        }
        
        $html .= '</tbody></table>';
        
        return $html;
    }
    public function adminSidebar(){
        return '<li class="nav-item"><a class="nav-link" href="'.HTML_PATH_ADMIN_ROOT.'configure-plugin/pluginUninstaller">Plugin Uninstaller</a></li>';
    }
}