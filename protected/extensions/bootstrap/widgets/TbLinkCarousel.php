<?php

Yii::import('bootstrap.widgets.TbCarousel');

class TbLinkCarousel extends TbCarousel
{

    protected function renderItems($items)
    {
        foreach ($items as $i => $item)
        {
            if (!is_array($item))
                continue;

            if (isset($item['visible']) && $item['visible'] === false)
                continue;

            if (!isset($item['itemOptions']))
                $item['itemOptions'] = array();

            $classes = array('item');

            if ($i === 0)
                $classes[] = 'active';

            if (!empty($classes))
            {
                $classes = implode(' ', $classes);
                if (isset($item['itemOptions']['class']))
                    $item['itemOptions']['class'] .= ' '.$classes;
                else
                    $item['itemOptions']['class'] = $classes;
            }

            echo CHtml::openTag('div', $item['itemOptions']);

            if (isset($item['image']))
            {
                if (!isset($item['alt']))
                    $item['alt'] = '';

                if (!isset($item['imageOptions']))
                    $item['imageOptions'] = array();

                $image = CHtml::image($item['image'], $item['alt'], $item['imageOptions']);

                if (isset($item['link']))
                    echo CHtml::link($image, $item['link']);
                else
                    echo $image;

            }

            if (!empty($item['caption']) && (isset($item['label']) || isset($item['caption'])))
            {
                if (!isset($item['captionOptions']))
                    $item['captionOptions'] = array();

                if (isset($item['captionOptions']['class']))
                    $item['captionOptions']['class'] .= ' carousel-caption';
                else
                    $item['captionOptions']['class'] = 'carousel-caption';

                echo CHtml::openTag('div', $item['captionOptions']);

                if (isset($item['label']))
                    echo '<h4>'.$item['label'].'</h4>';

                if (isset($item['caption']))
                    echo '<p>'.$item['caption'].'</p>';

                echo '</div>';
            }
            echo '</div>';
        }
    }
}