-- insert_data.sql

-- Insert initial basketball competitions
INSERT INTO basketballcompetitions (competition_name, gender)
VALUES
    ('NBA', 'male'),
    ('WNBA', 'female');

-- Insert initial basketball teams
INSERT INTO basketball_teams (team_name, gender)
VALUES
    ('Team A', 'male'),
    ('Team B', 'female'),
    ('Team C', 'male'),
    ('Team D', 'female');

-- Insert initial basketball matches (sample data)
INSERT INTO basketball_matches (match_date, match_time, home_team_id, away_team_id, home_score, away_score, venue, competition_id)
VALUES
    ('2024-07-05', '14:00:00', 1, 2, 80, 75, 'Stadium A', 1),
    ('2024-07-06', '15:30:00', 3, 4, 70, 85, 'Arena B', 1);

-- insert_data.sql

-- Insert initial competitions
INSERT INTO competitions (competition_name, gender)
VALUES
    ('Premier League', 'male'),
    ('FA Cup', 'male'),
    ('Women''s Super League', 'female');

-- Insert initial teams
INSERT INTO teams (team_name, gender)
VALUES
    ('Team A', 'male'),
    ('Team B', 'female'),
    ('Team C', 'male'),
    ('Team D', 'female');

-- Insert initial football matches (sample data)
INSERT INTO football_matches (match_date, match_time, home_team_id, away_team_id, home_score, away_score, venue, competition_id)
VALUES
    ('2024-07-05', '14:00:00', 1, 2, 2, 1, 'Stadium A', 1),
    ('2024-07-06', '15:30:00', 3, 4, 0, 3, 'Arena B', 1);
-- Insert initial data into rugby_teams
INSERT INTO rugby_teams (team_name, gender) VALUES
    ('Team A', 'male'),
    ('Team B', 'male'),
    ('Team C', 'female'),
    ('Team D', 'female');

-- Insert initial data into rugby_competitions
INSERT INTO rugby_competitions (competition_name, gender) VALUES
    ('Men Rugby League 2024', 'male'),
    ('Women Rugby Championship', 'female');

-- Insert initial data into rugby_matches
INSERT INTO rugby_matches (home_team_id, away_team_id, home_score, away_score, match_date, competition_id) VALUES
    (1, 2, 24, 18, '2024-07-05', 1),
    (3, 4, 12, 12, '2024-07-06', 2);

INSERT INTO news_posts (title, content, category, date, views) VALUES
    ('Introduction to Rugby Scoring', 'In rugby, points are scored...', 'Sports', '2024-07-04 09:00:00', 150),
    ('Top 10 Rugby Teams of All Time', 'A list of the greatest rugby teams...', 'Sports', '2024-07-03 14:30:00', 230),
    ('Women\'s Rugby World Cup Preview', 'Preview of the upcoming tournament...', 'Sports', '2024-07-02 11:45:00', 180),
    ('Rugby Tactics: Scrum Basics', 'Understanding the basics of scrums in rugby...', 'Sports', '2024-07-01 08:15:00', 120),
    ('Latest Updates on Rugby Sevens', 'Stay updated with the latest news on rugby sevens...', 'Sports', '2024-06-30 16:00:00', 200);

INSERT INTO `videos` (`title`, `description`, `url`, `category`, `thumbnail`)
VALUES ('Your Video Title', 'Description of your video.', 'path_to_video.mp4', 'Category Name', 'path_to_thumbnail.jpg');
