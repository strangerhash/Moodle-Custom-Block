<?php
class block_test extends block_base {
    public function init() {
        $this->title = get_string('test', 'block_test');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
    function has_config() {return true;}

    public function applicable_formats() {

        return array('all' => false,

                     'site' => false,

                     'site-index' => false,

                     'course-view' => true,

                     'course-view-social' => false,

                     'mod' => false,

                     'mod-quiz' => false
                    );

    }

    public function get_content() {
        if ($this->content !== null) {
          return $this->content;
        }

        global $COURSE;

        $this->content         = new stdClass;
        $this->content->items = array();  

        $coursecontext = context_course::instance($COURSE->id);
        $canview = has_capability('block/test:addinstance', $coursecontext);

        if (!$canview) return NULL;


        global $DB;
        $course_mods = get_course_mods($COURSE->id);
        $result = array();
        if($course_mods) {
         foreach($course_mods as $course_mod) {
          $course_mod->course_module_instance = $DB->get_record($course_mod->modname, array('id' =>$course_mod->instance ));
         $result[$course_mod->id] = $course_mod;
      }
    }

       $resultString = '';
       foreach ($result as $cminfo) {
        $resultString .= $cminfo->id.'&nbsp&nbsp'.$cminfo->course_module_instance->name.'&nbsp;&nbsp;'.date( "Y-m-d", $cminfo->added).'<br>';
      }
     $this->content->text = $resultString;

             
    return $this->content;
  }
        
}




