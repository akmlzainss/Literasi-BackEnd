<?php

$columns = \Illuminate\Support\Facades\Schema::getColumnListing('artikel');
echo "Columns in 'artikel' table:\n";
foreach ($columns as $col) {
    echo "- " . $col . "\n";
}
