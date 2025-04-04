<?php
session_start();
require_once __DIR__ . '/VoteController.php';

// Handle the vote submission
 VoteController::submitVote();