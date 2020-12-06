<?php
declare(strict_types=1);

class ShowData
{
    protected $stmt;

    public function __construct($stmt)
    {
        $this->stmt = $stmt;
    }

    public function showTable()
    {
        while($row = $this->stmt->fetch())
        {
            //$size  = count($row);
            //$size = floor(12/$size); Tentativa de arrumar o layout com bootstrap
            echo "<div class=\"row\" >";
            foreach ($row as $col) {
                echo <<<HTML
                
                                    <div class="col">
                                        <p> {$col} </p>
                                    </div>
                    
                HTML;
            }
            echo "    </div>\n";
        }
    }
}
