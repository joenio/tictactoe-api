<?php
class TicTacToeComputerPlayer {

  public function random_play($game) {
    $grid = $game->getGrid();
    for ($row = 0; $row < 3; $row++) {
      for ($column = 0; $column < 3; $column++) {
        if (is_null($grid[$row][$column])) {
          return array($row, $column);
        }
      }
    }
    return false;
  }

  public function mark($game, $symbol) {
    $value = TicTacToeComputerPlayer::random_play($game);
    if ($value) {
      $game->mark($value[0], $value[1], $symbol);
      return array($value[0], $value[1]);
    }
    return false;
  }

}
?>
