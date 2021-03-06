<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class AnnouncementBar extends BladeSection
{
    protected static string $description = 'You can show your announcements here';

    public static function settings(): array
    {
        return [
            CheckboxType::make('show_announcement', 'Show Announcement')
                ->default(true)
                ->info('You can toggle the announcement bar using this checkbox'),

            TextType::make('announcement', 'Announcement')
                ->default('Announcement text')
                ->info('The announcement text'),

            SelectType::make('position', 'Position')
                ->options([
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right',
                ])
                ->default('center')
                ->info('The announcement bar position'),
        ];
    }

    public function render()
    {
        return view('shop::sections.announcement-bar');
    }
}
