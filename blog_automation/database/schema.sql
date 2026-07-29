-- =========================================================
-- Media Jungle Blog CMS - Database Schema
-- =========================================================
-- Run this once to create the `blogs` table.
-- Adjust the database name below to match your existing DB,
-- or remove the CREATE DATABASE lines if you already have one.
-- =========================================================

CREATE DATABASE IF NOT EXISTS mediajungle_blog
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE mediajungle_blog;

CREATE TABLE IF NOT EXISTS blogs (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title         VARCHAR(255)     NOT NULL,
  description   TEXT             NOT NULL,
  thumbnail     VARCHAR(500)     NOT NULL,
  html_file     VARCHAR(500)     NOT NULL,
  publish_date  DATE             NOT NULL,
  created_at    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Seed data: migrates the 3 blog cards that are currently
-- hardcoded in index.html, so the site looks IDENTICAL the
-- moment you switch to the dynamic version. created_at values
-- are staggered so ORDER BY created_at DESC reproduces the
-- exact same card order you have today (Ownership, Scalability,
-- Launch Guide).
-- =========================================================

INSERT INTO blogs (title, description, thumbnail, html_file, publish_date, created_at) VALUES
(
  'How to Launch Your Own OTT Platform in 2025: A Step-by-Step Guide',
  'The OTT (Over-The-Top) streaming industry is booming, and with the increasing demand for on-demand content, launching your own OTT platform in 2025 presents an exciting opportunity. Whether you\'re a content creator, an entrepreneur, or a business looking to tap into the digital streaming market, understanding the right steps for launching an OTT platform is key to success. Here\'s a step-by-step guide on how to launch your own OTT platform in 2025.',
  'https://vsmartengine.com/assets/img/MJ/blog3.jpg',
  'blogmj.html#launch-guide',
  '2024-03-22',
  '2024-03-22 09:00:00'
),
(
  'The Importance of Scalability in OTT Platforms: How Media Jungle Handles Growth',
  'As the demand for on-demand content continues to rise, scalability has become one of the most important considerations for Over-The-Top (OTT) platforms. Scalability ensures that your platform can handle an increase in users, content, and data without compromising performance. For OTT providers, it\'s crucial to build a platform that can grow with the expanding demands of both the user base and content offerings. Here, we\'ll explore the significance of scalability in OTT platforms and how Media Jungle tackles the challenges of growth.',
  'https://vsmartengine.com/assets/img/MJ/blog2.jpg',
  'blogmj.html#scalability',
  '2024-04-02',
  '2024-04-02 09:00:00'
),
(
  'How Media Jungle Ensures Complete Ownership of Your OTT Content',
  'In the digital era, owning your OTT content is no longer a luxury\u2014it\u2019s a necessity. For creators and businesses, ownership goes beyond controlling the creative process; it extends to monetization, user engagement, and the long-term growth of your platform. Unfortunately, many OTT solutions operate on restrictive models that limit this control.',
  'https://vsmartengine.com/assets/img/MJ/blog1.jpg',
  'blogmj.html#ownership',
  '2024-04-14',
  '2024-04-14 09:00:00'
);
