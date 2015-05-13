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
            $_items = explode('==>', $key);
            if (count($_items) < 2) {
                $_items[] = '';
            }
            list($caller, $destination) = $_items;
            if (!array_key_exists($caller, $gropped)) {
                $gropped[$caller] = array();
            }
            $gropped[$caller][] = array($destination, $data);
        }


        $buffer .= '<table class="table table-hover table-profiling stupidtable">' . PHP_EOL;
        $buffer .= '<thead>' . PHP_EOL;
        $buffer .= '<tr>' . PHP_EOL;

        $buffer .= '<th data-sort="string">Call</th>';
        $buffer .= '<th> _call </th>';
        $buffer .= '<th> _ct </th>';
        $buffer .= '<th> _wt </th>';
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

            $_bufferDestination = '';
            $_bufferCt = '';
            $_bufferWt = '';
            foreach ($items as list($_destination, $_data)) {
                $_bufferDestination .= $_destination . '<br />';
                $_bufferCt .= $_data['ct'] . '<br />';
                $_bufferWt .= $_data['wt'] . '<br />';
                $data['ct'] += $_data['ct'];
                $data['wt'] += $_data['wt'];
            }
            $_bufferDestination = trim($_bufferDestination, '<br />');
            $_bufferCt = trim($_bufferCt, '<br />');
            $_bufferWt = trim($_bufferWt, '<br />');

            $buffer .= ' <tr>' . PHP_EOL;

            $buffer .= ' <td data-sort-value="' . $call . '">' . $call . '</td>';
            $buffer .= ' <td>' . $_bufferDestination . '</td>';
            $buffer .= ' <td>' . $_bufferCt . '</td>';
            $buffer .= ' <td>' . $_bufferWt . '</td>';
            $buffer .= ' <td data-sort-value="' . $data['ct'] . '">' . $data['ct'] . '</td>';
            $buffer .= ' <td data-sort-value="' . $data['wt'] . '">' . $data['wt'] . '</td>';
            $buffer .= ' <td data-sort-value="' . ($data['ct'] * $data['wt']) . '">' . ($data['ct'] * $data['wt']) . '</td>';

            $buffer .= PHP_EOL . ' </tr>' . PHP_EOL;
        }
        $buffer .= '</tbody>' . PHP_EOL;
        $buffer .= '</table>' . PHP_EOL;

        return $buffer;
    }

    public function renderSummary(array $stack)
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

        $sum = array('ct' => 0, 'wt' => 0);
        foreach ($stack as $call => $data) {
            $sum['ct'] = $sum['ct'] + $data['ct'];
            $sum['wt'] = $sum['wt'] + $data['wt'];
        }
        $buffer .= ' <tr>' . PHP_EOL;

        $buffer .= ' <td data-sort-value="Summary">Summary</td>';
        $buffer .= ' <td data-sort-value="' . $sum['ct'] . '">' . $data['ct'] . '</td>';
        $buffer .= ' <td data-sort-value="' . $sum['wt'] . '">' . $data['wt'] . '</td>';
        $buffer .= ' <td data-sort-value="' . ($sum['ct'] * $sum['wt']) . '">' . ($sum['ct'] * $sum['wt']) . '</td>';

        $buffer .= PHP_EOL . ' </tr>' . PHP_EOL;
        $buffer .= '</tbody>' . PHP_EOL;
        $buffer .= '</table>' . PHP_EOL;
        return $buffer;
    }
}