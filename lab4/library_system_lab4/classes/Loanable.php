<?php
interface Loanable {
    public function borrowBook();
    public function returnBook();
    public function isBorrowed();
}
?>