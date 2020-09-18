<?php namespace Dechman123\minesweeper\Controller;
    use function Dechman123\minesweeper\View\showGame;
    
    function startGame() {
        echo "Game started".PHP_EOL;
        showGame();
    }
?>