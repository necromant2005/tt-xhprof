<?php
namespace TweeXhprof\View\Helper;

class Xhprof
{
    public function __invoke(array $stack)
    {
        $buffer = '';
        $buffer .= '<table class="table table-hover table-profiling">' . PHP_EOL;
        $buffer .= '<thead>' . PHP_EOL;
        $buffer .= '<tr>' . PHP_EOL;

        $buffer .= '<td>Call</td>';
        $buffer .= '<td>Count</td>';
        $buffer .= '<td>Time</td>';
        $buffer .= '<td>Overall</td>';

        $buffer .=  PHP_EOL . '</tr>' . PHP_EOL;
        $buffer .= '</thead>' . PHP_EOL;
        $buffer .= '<tbody>' . PHP_EOL;
        foreach ($stack as $call => $data) {
            $buffer .= ' <tr>' . PHP_EOL;

            $buffer .= ' <td>' . $call . '</td>';
            $buffer .= ' <td>' . $data['ct'] . '</td>';
            $buffer .= ' <td>' . $data['wt'] . '</td>';
            $buffer .= ' <td>' . ($data['ct'] * $data['wt']) . '</td>';

            $buffer .= PHP_EOL . ' </tr>' . PHP_EOL;
        }
        $buffer .= '</tbody>' . PHP_EOL;
        $buffer .= '</table>' . PHP_EOL;
        return $buffer;
    }
}