<?php

/**
 * This file is part of phpMorphy library
 *
 * Copyright c 2007-2008 Kamaev Vladimir <heromantor@users.sourceforge.net>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the
 * Free Software Foundation, Inc., 59 Temple Place - Suite 330,
 * Boston, MA 02111-1307, USA.
 */

/**
 * This file is autogenerated at Wed, 14 Oct 2009 01:34:00 +0400, don`t change it!
 */
class phpMorphy_Graminfo_Shm extends phpMorphy_Graminfo {

    function getGramInfoHeaderSize() {
        return 20;
    }

    function readGramInfoHeader($offset) {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];


        $result = unpack(
                'vid/vfreq/vforms_count/vpacked_forms_count/vancodes_count/vancodes_offset/vancodes_map_offset/vaffixes_offset/vaffixes_size/vbase_size', shmop_read($__shm, $__offset + ($offset), 20)
        );

        $result['offset'] = $offset;

        return $result;
    }

    protected function readAncodesMap($info) {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];

        // TODO: this can be wrong due to aligning ancodes map section
        $offset = $info['offset'] + 20 + $info['forms_count'] * 2;


        $forms_count = $info['packed_forms_count'];
        return unpack("v$forms_count", shmop_read($__shm, $__offset + ($offset), $forms_count * 2));
    }

    protected function splitAncodes($ancodes, $map) {
        $result = array();
        for ($i = 1, $c = count($map), $j = 1; $i <= $c; $i++) {
            $res = array();

            for ($k = 0, $kc = $map[$i]; $k < $kc; $k++, $j++) {
                $res[] = $ancodes[$j];
            }

            $result[] = $res;
        }

        return $result;
    }

    function readAncodes($info) {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];

        // TODO: this can be wrong due to aligning ancodes section
        $offset = $info['offset'] + 20;


        $forms_count = $info['forms_count'];
        $ancodes = unpack("v$forms_count", shmop_read($__shm, $__offset + ($offset), $forms_count * 2));

        /*
          if(!$expand) {
          return $ancodes;
          }
         */

        $map = $this->readAncodesMap($info);

        return $this->splitAncodes($ancodes, $map);
    }

    function readFlexiaData($info) {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];

        $offset = $info['offset'] + 20;

        if (isset($info['affixes_offset'])) {
            $offset += $info['affixes_offset'];
        } else {
            $offset += $info['forms_count'] * 2 + $info['packed_forms_count'] * 2;
        }


        return explode($this->ends, shmop_read($__shm, $__offset + ($offset), $info['affixes_size'] - $this->ends_size));
    }

    function readAllGramInfoOffsets() {
        return $this->readSectionIndex($this->header['flex_index_offset'], $this->header['flex_count']);
    }

    protected function readSectionIndex($offset, $count) {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];


        return array_values(unpack("V$count", shmop_read($__shm, $__offset + ($offset), $count * 4)));
    }

    function readAllFlexia() {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];

        $result = array();

        $offset = $this->header['flex_offset'];

        foreach ($this->readSectionIndexAsSize($this->header['flex_index_offset'], $this->header['flex_count'], $this->header['flex_size']) as $size) {
            $header = $this->readGramInfoHeader($offset);
            $affixes = $this->readFlexiaData($header);
            $ancodes = $this->readAncodes($header, true);

            $result[$header['id']] = array(
                'header' => $header,
                'affixes' => $affixes,
                'ancodes' => $ancodes
            );

            $offset += $size;
        }

        return $result;
    }

    function readAllPartOfSpeech() {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];

        $result = array();

        $offset = $this->header['poses_offset'];

        foreach ($this->readSectionIndexAsSize($this->header['poses_index_offset'], $this->header['poses_count'], $this->header['poses_size']) as $size) {


            $res = unpack(
                    'vid/Cis_predict', shmop_read($__shm, $__offset + ($offset), 3)
            );

            $result[$res['id']] = array(
                'is_predict' => (bool) $res['is_predict'],
                'name' => $this->cleanupCString(shmop_read($__shm, $__offset + ($offset + 3), $size - 3))
            );

            $offset += $size;
        }

        return $result;
    }

    function readAllGrammems() {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];

        $result = array();

        $offset = $this->header['grammems_offset'];

        foreach ($this->readSectionIndexAsSize($this->header['grammems_index_offset'], $this->header['grammems_count'], $this->header['grammems_size']) as $size) {


            $res = unpack(
                    'vid/Cshift', shmop_read($__shm, $__offset + ($offset), 3)
            );

            $result[$res['id']] = array(
                'shift' => $res['shift'],
                'name' => $this->cleanupCString(shmop_read($__shm, $__offset + ($offset + 3), $size - 3))
            );

            $offset += $size;
        }

        return $result;
    }

    function readAllAncodes() {
        $__shm = $this->resource['shm_id'];
        $__offset = $this->resource['offset'];

        $result = array();

        $offset = $this->header['ancodes_offset'];


        for ($i = 0; $i < $this->header['ancodes_count']; $i++) {
            $res = unpack('vid/vpos_id', shmop_read($__shm, $__offset + ($offset), 4));
            $offset += 4;

            list(, $grammems_count) = unpack('v', shmop_read($__shm, $__offset + ($offset), 2));
            $offset += 2;

            $result[$res['id']] = array(
                'pos_id' => $res['pos_id'],
                'grammem_ids' => $grammems_count ?
                        array_values(unpack("v$grammems_count", shmop_read($__shm, $__offset + ($offset), $grammems_count * 2))) :
                        array(),
                'offset' => $offset,
            );

            $offset += $grammems_count * 2;
        }

        return $result;
    }

}
