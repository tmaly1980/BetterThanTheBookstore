<?
echo "<form method='POST' action='/admin/users/send_email'>\n";

echo $form->input('school_id',array('label'=>'Specific School','options'=>$schools);
echo $form->input('subject');

echo $form->input('content',array('label'=>'Content','rows'=>20, 'cols'=>50));

echo $form->end("Send Bulk Email");
?>
