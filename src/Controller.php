<?php

namespace Dechman123\minesweeper\Controller;

use function Dechman123\minesweeper\View\showGame;
use function Dechman123\minesweeper\Model\createVars;
use function Dechman123\minesweeper\Model\createCellsArray;
use function Dechman123\minesweeper\Model\isBomb;
use function Dechman123\minesweeper\Model\openArea;
use function Dechman123\minesweeper\Model\setFlag;

function gameLoop()
{
    global $cellsArray, $lostGame, $openedCellsCount;
    $turnCount = 1;
    while (true) {
        showGame($turnCount);
        $turnCount++;
        
        $inputString = \cli\prompt(
            "Введите координаты x, y ячейки через "
            . "запятую без пробела.\nЕсли хотите "
            . "установить флаг в ячейку, то введите "
            . "F (так же через запятую) после ввода координат"
        );
        $playing_field = explode(',', $inputString);
        if (
            !isset($playing_field[0]) || !isset($playing_field[1])
            || preg_match('/^[0-9]{1}$/', $playing_field[0]) == 0
            || preg_match('/^[0-9]{1}$/', $playing_field[1]) == 0
        ) {
            \cli\line("Неверно введены данные! Попробуйте еще раз");
            $turnCount--;
        } else {
            if (
                isset($playing_field[2])
                && ($playing_field[2] == 'F' || $playing_field[2] == 'f')
            ) {
                setFlag($playing_field[0], $playing_field[1]);
            } else {
                if (isBomb($playing_field[0], $playing_field[1])) {
                    showGame($turnCount);
                    \cli\line("Конец");
                    break;
                } else {
                    openArea($playing_field[0], $playing_field[1]);
                    if ($openedCellsCount == count($cellsArray) * count($cellsArray[0])) {
                        showGame($turnCount);
                        \cli\line("CONGRATULATIONS! YOU WON");
                        break;
                    }
                }
            }
        }
    }
}

function startGame()
{
    createVars();
    createCellsArray();
    gameLoop();
}
