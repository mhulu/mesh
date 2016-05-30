<?php 
namespace Star\Forms;

/**
 * summary
 */
class PublishTestForm extends Forms
{
    protected $rules = [
        'body' => 'required'
        ];

    public function persist()
    {
        var_dump('expression');
    }
}