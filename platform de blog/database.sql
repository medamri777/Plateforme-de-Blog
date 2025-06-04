-- Create database
CREATE DATABASE IF NOT EXISTS blog_platform;
USE blog_platform;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    slug VARCHAR(50) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    image VARCHAR(255),
    status ENUM('draft', 'published') DEFAULT 'published',
    views INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Create comments table
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create likes table
CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (post_id, user_id)
);

-- Insert admin user
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@example.com', '$2y$10$Nt1UbHWjwuMVeK7VhTtPZu7FpTEwi/cjWH8YEjMtRuAQeEtFrPTVS', 'admin');
-- Password: admin123

-- Insert sample categories
INSERT INTO categories (name, description, slug) VALUES 
('Tourisme', 'Découvrez les attractions touristiques de Nador et ses environs', 'tourisme'),
('Culture', 'Articles sur la culture, traditions et art marocain', 'culture'),
('Gastronomie', 'Recettes et spécialités culinaires de Nador et du Maroc', 'gastronomie'),
('Événements', 'Festivals, célébrations et événements locaux', 'evenements'),
('Histoire', 'Histoire de Nador et du patrimoine marocain', 'histoire');

-- Insert sample posts
INSERT INTO posts (user_id, category_id, title, slug, content) VALUES 
(1, 1, 'Les plages incontournables de Nador', 'plages-incontournables-nador', 'Nador est réputée pour ses magnifiques plages méditerranéennes. La plage de Bocana, située près du centre-ville, est parfaite pour les familles avec ses eaux calmes et peu profondes. Pour ceux qui recherchent un cadre plus sauvage, la plage d\'Arekmane offre des paysages à couper le souffle avec son sable doré et ses dunes. La plage de Kariat Arekmane est également très appréciée des locaux et des touristes pour sa propreté et la qualité de son eau. Ces plages sont particulièrement agréables à visiter entre juin et septembre, lorsque les températures sont idéales pour la baignade. N\'oubliez pas votre crème solaire et profitez du soleil marocain!'),
(1, 2, 'Festival Culturel International de Nador', 'festival-culturel-nador', 'Chaque année, Nador accueille le Festival Culturel International qui célèbre la diversité artistique et culturelle de la région. Ce festival met en vedette des artistes locaux et internationaux à travers une variété de spectacles, concerts et expositions. Les visiteurs peuvent découvrir la musique traditionnelle amazighe, des danses folkloriques et des performances contemporaines. Le festival est également l\'occasion de mettre en valeur l\'artisanat local avec des démonstrations de tissage, poterie et autres métiers traditionnels. C\'est un événement qui témoigne de la richesse culturelle de Nador et renforce son statut de carrefour culturel dans la région du Rif.'),
(1, 3, 'Tajine de poisson à la façon de Nador', 'tajine-poisson-nador', 'Le tajine de poisson est une spécialité culinaire emblématique de Nador, qui reflète parfaitement sa position côtière privilégiée. Pour préparer ce plat savoureux, on utilise généralement des poissons frais locaux comme le loup de mer ou la dorade. Les poissons sont marinés dans un mélange d\'épices marocaines comprenant le cumin, le paprika, le gingembre et le safran. On ajoute ensuite des tomates fraîches, des poivrons, de l\'ail, des olives et des citrons confits. Le tout est cuit lentement dans un tajine traditionnel en terre cuite, ce qui permet aux saveurs de se mélanger parfaitement. Ce plat est généralement servi avec du pain marocain frais pour absorber la délicieuse sauce. C\'est un véritable délice qui représente l\'essence même de la cuisine côtière marocaine.'),
(1, 4, 'Moussem de Sidi Ali à Nador', 'moussem-sidi-ali-nador', 'Le Moussem de Sidi Ali est l\'une des célébrations religieuses et culturelles les plus importantes de la région de Nador. Ce pèlerinage annuel honore la mémoire de Sidi Ali, un saint vénéré localement. Des milliers de fidèles se rassemblent pour participer à des prières collectives, des récitations du Coran et des chants religieux. Le Moussem est également une occasion festive avec des spectacles de fantasia (démonstrations équestres traditionnelles), de la musique folklorique et des marchés temporaires où les artisans locaux vendent leurs créations. Cette célébration témoigne de l\'importance des traditions spirituelles dans la culture marocaine et offre un aperçu fascinant de la façon dont les pratiques religieuses et les festivités populaires se mêlent harmonieusement dans la région de Nador.'),
(1, 5, 'L\'histoire de la Lagune de Marchica', 'histoire-lagune-marchica', 'La Lagune de Marchica, également connue sous le nom de Mar Chica, est un joyau naturel qui a façonné l\'histoire de Nador depuis des siècles. Cette immense lagune d\'eau salée, séparée de la Méditerranée par un cordon littoral, a longtemps été un lieu stratégique et une source de subsistance pour les populations locales. Les Phéniciens et les Romains l\'utilisaient déjà comme port naturel pour leurs navires commerciaux. Au cours de la période coloniale espagnole, la lagune a joué un rôle militaire important. Aujourd\'hui, Marchica fait l\'objet d\'un ambitieux projet de développement écotouristique visant à préserver sa biodiversité exceptionnelle tout en créant des infrastructures modernes. Ce plan de réhabilitation transforme progressivement la lagune en une destination touristique de premier plan, tout en respectant son riche patrimoine historique et écologique.');

-- Insert sample comments
INSERT INTO comments (post_id, user_id, content) VALUES 
(1, 1, 'J\'ai visité la plage d\'Arekmane l\'été dernier et c\'était vraiment magnifique! L\'eau était cristalline et le sable très propre.'),
(2, 1, 'J\'ai eu la chance d\'assister au festival l\'année dernière, les performances étaient extraordinaires, surtout les groupes de musique amazighe!'),
(3, 1, 'J\'ai essayé cette recette et le résultat était délicieux! Le mélange d\'épices est parfait avec le poisson frais.'),
(4, 1, 'Le Moussem est vraiment un événement à ne pas manquer si vous visitez Nador. L\'ambiance est incroyable et on découvre beaucoup sur les traditions locales.'),
(5, 1, 'La Lagune de Marchica est un endroit fascinant, je recommande vivement une excursion en bateau pour découvrir toute sa beauté.'); 