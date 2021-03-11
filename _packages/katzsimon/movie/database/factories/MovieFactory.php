<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $movies = array(
        'La La Land', 'Saving Private Ryan', 'Psycho', 'The Godfather', 'Singing in the rain', 'The Artist',
        'Parasite', 'Life is beautiful', 'American Beauty', 'The Professional', 'Once Upon a Time in the West',
        'Once Upon a Time in America', 'Casablanca', 'The Pianist', 'The Departed', 'Terminator', 'Terminator 2',
        'American History X', 'Interstellar', 'The Green Mile', 'The Dark Knight', 'Batman', 'Iron Man', 'Avengers',
        'Man of Steel', 'The Watchmen', '300', '12 Angry Men', 'A bout de souffle', 'Le mépris', 'Star Wars', 'Se7en',
        'City of God', 'Fight Club', 'Gone Girl', 'The Matrix', 'The Lord of the Rings', 'GoodFellas', 'Casino',
        'Inception', 'Forrest Gump', 'Star Wars Episode V : The Empire Strikes Back', 'Memento', 'Inside Out', 'Coco',
        'The Lion King', 'Old Boy', 'Django Unchained', 'Kill Bill', 'Paths of Glory', 'The Shining', 'Enemy',
        'Citizen Kane', 'Vertigo', 'Reservoir Dogs', 'Pulp Fiction', 'Inglorious Basterds', 'Edward Cisorhands',
        'Braveheart', 'Hacksaw Ridge', 'Amadeus', 'Taxi Driver', 'Toy Story', 'Toy Story 3', 'Good Will Hunting',
        'The Shawkawk Redemption', 'Gravity', 'Drive', 'The Neon Demon', 'Gladiator', 'Shame', '12 Years a Slave',
        'Blade Runner', 'Blade Runner 2049', 'Arrival', 'Incendies', 'Polytechnique', 'Black Swan', 'Mother!',
        'Rosemary\'s Baby', 'The Aviator', 'The Irishman', 'The Wolf of Wall Street', 'Ad Astra', 'We Own the Night',
        '2001 : A Space Odyssey', 'A Clockwork Orange', 'The Schindler List', 'The Good, The Bad and The Ugly',
        'Harakiri', 'Seven Samurai', 'Joker', 'Whiplash', 'The Prestige', 'Cinema Paradiso', 'Back to the Future',
        'Back to the Future 2', 'Your Name', 'Alien', 'Rear Window', 'North by Northwest', 'The Lobster', 'Zodiac',
        'The Great Dictator', 'Eternal Sunshine of the Spotless Mind', 'Amelie from Montmartre', 'Requiem for a Dream',
        'Snatch', 'Full Metal Jacket', 'Sicario', 'Dune', 'Aliens', 'Scarface', 'Lawrence of Arabie', 'Leto', 'Hugo',
        'Green Book', 'Three Billboards Outside Ebbing Misouri', 'Seven Psychopaths', 'Silence', 'Collateral',
        'Winter Sleep', 'Warrior', 'The Wolf of Wall Street', 'There Will Be Blood', 'V for Vendetta', 'Heat',
        'A Beautiful Mind', 'L.A. Confidential', 'Raging Bull', 'Ran', 'Monty Python : Holy Grail', 'Chinatown',
        'Andreï Roublev', 'Stalker', 'The Handmaiden', 'Logan', 'Room', 'The Room', 'The Grand Budapest Hotel',
        'Moonrise Kingdom', 'Fantastic Mr.Fox', 'Ford v Ferrari', 'Spotlight', 'The Help', 'Prisoners', 'Gran Torino',
        'Mad Max : Fury Road', 'Shutter Island', 'Mary and Max', 'Dragons', 'Into the Wild', 'No Country for Old Men',
        'The Big Lebowski', 'Memories of Murder', 'Kill Bill Vol.1', 'Kill Bill Vol.2', 'Batman Returns', 'Babel',
        'Catch me if you can', 'Finding Nemo', 'The Sixth Sense', 'Unbreakable', 'Signs', 'Avatar', 'Titanic',
        'In the Mood for Love', 'Trainspotting', 'The Truman Show', 'Fargo', 'Jurassic Park', 'Stand by Me',
        'Grease', 'Platoon', 'The Deer Hunter', 'Paris, Texas', 'The Thing', 'The Hateful Height', 'Elephant Man',
        'Once Upon a Time In Hollywood', 'The Life of Brian', 'Creed', 'The Social Network', 'Panic Room', 'Persona',
        'The Girl with a Dragon Tatoo', 'Ben-hur', 'Suspiria', 'Akira', 'Jaws', 'Apocalypse Now', 'Ghostbusters',
        'Eyes Wide Shut', 'Skyfall', 'Blow Out', 'Carrie', 'Carlito\'s Way', 'Mission : Impossible', 'Cotton Club'
    );

    protected $genres = array(
        'Comedy', 'Action', 'Adventure', 'Thriller', 'Music', 'Suspense', 'Drama', 'Crime', 'Romance', 'Animation',
        'Fantasy', 'Science Fiction', 'Western', 'War', 'History', 'Mystery', 'Horror', 'Biography', 'Documentary',
        'Family', 'TV Movie'
    );


    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->movies[array_rand($this->movies)],
            'genre' => $this->genres[array_rand($this->genres)],
            'runtime'=> rand(70, 200),
            'rating' => rand(1, 5),
            'starring' => function(){
                $rand = rand(1, 3);
                $names = [];
                for ($i=1; $i<=$rand; $i++) {
                    $names[] = $this->faker->name;
                }
                return implode(', ', $names);
            },
            'description'=> $this->faker->paragraphs(3, true),
        ];
    }
}
