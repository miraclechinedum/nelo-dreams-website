# Team photos

Headshots for the home-page team section, cropped from the foundation's ID cards.
The filenames match the `photo` paths in `database/seeders/TeamMemberSeeder.php`:

    ebere-amariazu.jpg      Coach Ebere Amariazu — Executive Director
    kennedy-okoro.jpg       Kennedy Obinna Okoro — Project Implementation / Evaluation Manager
    kennedy-onwunali.jpg    Kennedy Onwunali — Media Officer
    esther-osayi.jpg        Esther Osayi — Field Officer / Community Mobilizer
    amaka-obi.jpg           Amaka S Obi — Field Officer / Program

They are 800x1000 (4:5), matching the card shape, and the cards crop from the top
so faces stay in frame at every screen size.

To swap someone's photo, either replace the file here with another 4:5 image, or
upload a new one from **Admin → Team → Edit** — an upload is stored under
`public/uploads/` and takes precedence over the path above. A member with no photo
at all falls back to their initials.
