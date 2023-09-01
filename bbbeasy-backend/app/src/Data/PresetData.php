<?php

declare(strict_types=1);

/*
 * BBBEasy open source platform - https://riadvice.tn/
 *
 * Copyright (c) 2022-2023 RIADVICE SUARL and by respective authors (see below).
 *
 * This program is free software; you can redistribute it and/or modify it under the
 * terms of the GNU Lesser General Public License as published by the Free Software
 * Foundation; either version 3.0 of the License, or (at your option) any later
 * version.
 *
 * BBBEasy is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with BBBEasy; if not, see <http://www.gnu.org/licenses/>.
 */

namespace Data;

class PresetData
{
    private array $data = [];

    public function setData($category, $subCategory, $value): void
    {
        if (null !== $value) {
            $this->data[$category][$subCategory] = $value;
        }
    }

    public function getData($category, $subCategory)
    {
        // @fixme: should return null if not found
        // if (\array_key_exists($category, $this->data) && \array_key_exists($category, $this->data[$category])) {
        return $this->data[$category][$subCategory];
        // }

        // return null;
    }
}
