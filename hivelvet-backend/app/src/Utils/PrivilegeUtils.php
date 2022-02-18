<?php

declare(strict_types=1);

/*
 * Hivelvet open source platform - https://riadvice.tn/
 *
 * Copyright (c) 2022 RIADVICE SUARL and by respective authors (see below).
 *
 * This program is free software; you can redistribute it and/or modify it under the
 * terms of the GNU Lesser General Public License as published by the Free Software
 * Foundation; either version 3.0 of the License, or (at your option) any later
 * version.
 *
 * Hivelvet is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with Hivelvet; if not, see <http://www.gnu.org/licenses/>.
 */

namespace Utils;

use Composer\Autoload\ClassLoader;
use RectorPrefix20220209\Tracy\Debugger;

class PrivilegeUtils
{
    public static function listSystemPrivileges(): array
    {
        $privileges = [];
        $trait = 'Actions\RequirePrivilegeTrait';

        $res = get_declared_classes();
        $autoloaderClassName = '';
        foreach ($res as $className) {
            if (str_starts_with($className, 'ComposerAutoloaderInit')) {
                $autoloaderClassName = $className;
                break;
            }
        }
        $classLoader = $autoloaderClassName::getLoader();

        /*
         * @todo:
         * 1 - Filter classes starting with Actions\                        => done
         * 2 - Retain classes having only a secondary names space (2 \)     => done
         * 3 - Filter classes having RequirePrivilegeTrait                  => done
         * 4 - Actions\Group\PrivilegeName                                  => done
         * 5 - Later put the list in redis cache when the application starts the first time
         */
        $classMap = $classLoader->getClassMap();
        $actions = preg_filter('/^Actions\\\[A-Z a-z]*\\\[A-Z a-z]*/', '$0', array_keys($classMap));
        Debugger::dump($actions);

        foreach ($actions as $action) {
            $class = new \ReflectionClass($action);
            if(!empty($class->getTraits()) && in_array($trait,$class->getTraitNames())) {
                $privilegeInfos = explode("\\", $action);
                array_shift($privilegeInfos);
                $privilege = [];
                $privilege['group'] = $privilegeInfos[0];
                $privilege['name'] = $privilegeInfos[1];
                array_push($privileges,$privilege);
            }
        }

        Debugger::dump($privileges);
        return $privileges;
    }
}
