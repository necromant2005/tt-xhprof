<?php
namespace TweeXhprof\View\Helper;

class Xhprof
{
    public function __invoke(array $stack)
    {
        $buffer = '';
        $buffer .= '<table class="table table-hover table-profiling stupidtable">' . PHP_EOL;
        $buffer .= '<thead>' . PHP_EOL;
        $buffer .= '<tr>' . PHP_EOL;

        $buffer .= '<td data-sort="string">Call</td>';
        $buffer .= '<td data-sort="int">Count</td>';
        $buffer .= '<td data-sort="int">Time</td>';
        $buffer .= '<td data-sort="int">Overall</td>';

        $buffer .=  PHP_EOL . '</tr>' . PHP_EOL;
        $buffer .= '</thead>' . PHP_EOL;
        $buffer .= '<tbody>' . PHP_EOL;
        foreach ($stack as $call => $data) {
            $buffer .= ' <tr>' . PHP_EOL;

            $buffer .= ' <td data-sort-value="' . $call . '">' . $call . '</td>';
            $buffer .= ' <td data-sort-value="' . $data['ct'] . '">' . $data['ct'] . '</td>';
            $buffer .= ' <td data-sort-value="' . $data['wt'] . '">' . $data['wt'] . '</td>';
            $buffer .= ' <td data-sort-value="' . ($data['ct'] * $data['wt']) . '">' . ($data['ct'] * $data['wt']) . '</td>';

            $buffer .= PHP_EOL . ' </tr>' . PHP_EOL;
        }
        $buffer .= '</tbody>' . PHP_EOL;
        $buffer .= '</table>' . PHP_EOL;
        return $buffer;
    }
}