<?php
namespace TweeXhprof\View\Helper;

class Xhprof
{
    public function __invoke()
    {
        return $this;
    }

    public function __toString()
    {
        return '';
    }

    public function render(array $stack)
    {
        $buffer = '';
        $buffer .= '<table class="table table-hover table-profiling stupidtable">' . PHP_EOL;
        $buffer .= '<thead>' . PHP_EOL;
        $buffer .= '<tr>' . PHP_EOL;

        $buffer .= '<th data-sort="string">Call</th>';
        $buffer .= '<th data-sort="int">Count</th>';
        $buffer .= '<th data-sort="int">Time</th>';
        $buffer .= '<th data-sort="int">Overall</th>';

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

    public function renderGroup(array $stack)
    {
        $buffer = '';

        $gropped = array();
        foreach ($stack as $key => $data) {
            list($caller, $destination) = explode('==>', $key);
            if (!array_key_exists($caller, $gropped)) {
                $gropped[$caller] = array();
            }
            $gropped[$caller][] = array($destination, $data);
        }


        $buffer .= '<table class="table table-hover table-profiling stupidtable">' . PHP_EOL;
        $buffer .= '<thead>' . PHP_EOL;
        $buffer .= '<tr>' . PHP_EOL;

        $buffer .= '<th data-sort="string">Call</th>';
        $buffer .= '<th> - </th>';
        $buffer .= '<th data-sort="int">Count</th>';
        $buffer .= '<th data-sort="int">Time</th>';
        $buffer .= '<th data-sort="int">Overall</th>';

        $buffer .=  PHP_EOL . '</tr>' . PHP_EOL;
        $buffer .= '</thead>' . PHP_EOL;
        $buffer .= '<tbody>' . PHP_EOL;
        foreach ($gropped as $call => $items) {
            $data = array(
                'ct' => 0,
                'wt' => 0,
            );

            $_buffer = '';
            foreach ($items as list($_destination, $_data)) {
                $_buffer .= $destination . '<br />';
                $data['ct'] += $_data['ct'];
                $data['wt'] += $_data['wt'];
            }
            $_buffer = trim($_buffer, '<br />');

            $buffer .= ' <tr>' . PHP_EOL;

            $buffer .= ' <td data-sort-value="' . $call . '">' . $call . '</td>';
            $buffer .= ' <td>' . $_buffer . '</td>';
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