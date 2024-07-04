-- create_tables.sql

-- Table: basketballcompetitions
CREATE TABLE basketballcompetitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL
);

-- Table: basketball_teams
CREATE TABLE basketball_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL
);

-- Table: basketball_matches
CREATE TABLE basketball_matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_date DATE NOT NULL,
    match_time TIME NOT NULL,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    home_score INT NOT NULL,
    away_score INT NOT NULL,
    venue VARCHAR(255),
    competition_id INT NOT NULL,
    FOREIGN KEY (home_team_id) REFERENCES basketball_teams(id),
    FOREIGN KEY (away_team_id) REFERENCES basketball_teams(id),
    FOREIGN KEY (competition_id) REFERENCES basketballcompetitions(id)
);

-- Table: basketball_standings
CREATE TABLE basketball_standings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_id INT NOT NULL,
    team_id INT NOT NULL,
    team_name VARCHAR(255) NOT NULL,
    games_played INT NOT NULL DEFAULT 0,
    wins INT NOT NULL DEFAULT 0,
    losses INT NOT NULL DEFAULT 0,
    points_for INT NOT NULL DEFAULT 0,
    points_against INT NOT NULL DEFAULT 0,
    win_percentage DECIMAL(5, 3) NOT NULL DEFAULT 0,
    FOREIGN KEY (competition_id) REFERENCES basketballcompetitions(id),
    FOREIGN KEY (team_id) REFERENCES basketball_teams(id)
);
-- create_tables.sql

-- Table: competitions
CREATE TABLE competitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL
);

-- Table: teams
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL
);

-- Table: football_matches (assuming this structure based on previous discussions)
CREATE TABLE football_matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_date DATE NOT NULL,
    match_time TIME NOT NULL,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    home_score INT,
    away_score INT,
    venue VARCHAR(255),
    competition_id INT NOT NULL,
    FOREIGN KEY (home_team_id) REFERENCES teams(id),
    FOREIGN KEY (away_team_id) REFERENCES teams(id),
    FOREIGN KEY (competition_id) REFERENCES competitions(id)
);

-- Table: standings
CREATE TABLE standings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_id INT NOT NULL,
    team_id INT NOT NULL,
    team_name VARCHAR(255) NOT NULL,
    played INT DEFAULT 0,
    won INT DEFAULT 0,
    drawn INT DEFAULT 0,
    lost INT DEFAULT 0,
    goals_for INT DEFAULT 0,
    goals_against INT DEFAULT 0,
    goal_difference INT DEFAULT 0,
    points INT DEFAULT 0,
    FOREIGN KEY (competition_id) REFERENCES competitions(id),
    FOREIGN KEY (team_id) REFERENCES teams(id)
);
-- Create rugby_teams table
CREATE TABLE rugby_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female') NOT NULL
);

-- Create rugby_matches table
CREATE TABLE rugby_matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    home_score INT,
    away_score INT,
    match_date DATE,
    competition_id INT,
    FOREIGN KEY (home_team_id) REFERENCES rugby_teams(id),
    FOREIGN KEY (away_team_id) REFERENCES rugby_teams(id),
    FOREIGN KEY (competition_id) REFERENCES rugby_competitions(id)
);

-- Create rugby_standings table
CREATE TABLE rugby_standings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_id INT NOT NULL,
    team_id INT NOT NULL,
    team_name VARCHAR(100) NOT NULL,
    games_played INT DEFAULT 0,
    wins INT DEFAULT 0,
    losses INT DEFAULT 0,
    draws INT DEFAULT 0,
    points_for INT DEFAULT 0,
    points_against INT DEFAULT 0,
    points_difference INT DEFAULT 0,
    points INT DEFAULT 0,
    FOREIGN KEY (competition_id) REFERENCES rugby_competitions(id),
    FOREIGN KEY (team_id) REFERENCES rugby_teams(id)
);

-- Create rugby_competitions table
CREATE TABLE rugby_competitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    competition_name VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female') NOT NULL
);

CREATE TABLE IF NOT EXISTS news_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50),
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    views INT DEFAULT 0
);
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `description` text,
  `url` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `upload_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `thumbnail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

