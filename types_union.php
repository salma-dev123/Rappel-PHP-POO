<?php
function normalizeId(int|string $id): int {
    if (is_string($id)) {
        $id = (int)trim($id);
    }
    return max(0, $id);
}

