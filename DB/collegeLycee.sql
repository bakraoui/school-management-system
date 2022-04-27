
--
-- Déchargement des données de la table `branch`
--

INSERT INTO `branch` (`id_branch`, `title_branch`, `description_branch`, `is_deleted`) VALUES
(1, 'Niveau 1', 'desc', 0),
(2, 'Niveau 2', 'desc', 0);

-- --------------------------------------------------------

--
-- Déchargement des données de la table `class`
--

INSERT INTO `class` (`id_class`, `title_class`, `id_branch`, `is_deleted`) VALUES
(1, 'N1G1', 1, 0),
(2, 'N1G2', 1, 0),
(3, 'N2G3', 2, 0),
(4, 'N2G4', 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `classroom`
--

-- Déchargement des données de la table `classroom`
--

INSERT INTO `classroom` (`id_classroom`, `title_classroom`, `is_deleted`) VALUES
(1, 'S1', 0),
(2, 'S2', 0),
(3, 'S3', 0),
(4, 'S4', 0);

-- --------------------------------------------------------




--
-- Déchargement des données de la table `school`
--

INSERT INTO `school` (`id_school`, `name`, `adress`, `city`, `logo`, `type`, `email`, `tele`, `facebook`, `linked`, `insta`, `twitter`, `director`, `about`, `low`) VALUES
(1, 'Eddoha', 'El Houda', 'Agadir', NULL, 2, 'eddoha@gmail.com', '+44666666600', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------


--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id_session`, `date_start`, `date_end`, `is_deleted`) VALUES
(1, 2021, 2022, 0);

--
-- Déchargement des données de la table `semester`
--

INSERT INTO `semester` (`id_semester`, `title_semester`, `id_session`, `is_deleted`) VALUES
(1, 'first semester', 1, 0);






--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id_user`, `fname_user`, `lname_user`, `email_user`, `cin_user`, `cne_student`, `adress_user`, `city_user`, `image_user`, `password`, `is_deleted`) VALUES
(1, 'ETD', 'ETD1', 'E1@gmail.com', 'HJ80980945', 'FD2435432', '', '', NULL, '$2y$10$bWik9wD7UsKLJS0vsOlLT.2w0nM8td9CFjHt6kXoZlp4MaX3ev3QO', 0),
(2, 'ETD', 'ETD2', 'E2@gmail.com', 'G323243243', 'TY567465', '', '', NULL, '$2y$10$tyAo1CgAZQ7v7D3ccerccut7tXx4bQ1.oDkQR4Ch0zAHcgjTZtJ1a', 0),
(3, 'ETD', 'ETD3', 'E3@gmail.com', 'HJ8098097', 'TY5674654', '', '', NULL, '$2y$10$6YYaYZN6fHiMBJId3MsaluJrmidYsUF2l0goAtUUJLlLy9XRndPqi', 0),
(4, 'ETD', 'ETD4', 'E4@gmail.com', 'F43434354', 'FD24354324', '', '', NULL, '$2y$10$U5NwaGD1Ci18mD8tPoS6gOfyTiQAiCjZlN5iQD43wwkkKp77rv3E2', 0),
(5, 'ETD', 'ETD5', 'E5@gmail.com', 'HJ80980945', 'FD2435432', '', '', NULL, '$2y$10$PpeM0wWmGGuVnp57smEYFu36AmVZgwcHnYKj1cJ9WJnqui8GmWRJq', 0),
(6, 'ETD', 'ETD6', 'E6@gmail.com', 'HJ8098097', 'TY5674654', '', '', NULL, '$2y$10$bePiyistidGNsyA4sNePuuMuTwshXQQoR.4mVOHiGXQxrJLBJPkS6', 0),
(7, 'ETD', 'ETD7', 'E7@gmail.com', 'HJ80980945', 'FD2435432', '', '', NULL, '$2y$10$u9OikfDocy4.13pzUgHyWuJtT5APzr0IukiTy5GRixytHuuioWuwq', 0),
(8, 'ETD', 'ETD8', 'E8@gmail.com', 'G323243243', 'TY5674654', '', '', NULL, '$2y$10$VmofoFW9ktAa0gdtLWGg5OhS/PnMpGUyPnlVgahP.QS7PbnD9g.cq', 0);

-- --------------------------------------------------------

--

--
-- Déchargement des données de la table `subject`
--

INSERT INTO `subject` (`id_subject`, `id_module`, `title_subject`, `coefficient`, `percentage`, `is_deleted`) VALUES
(1, 0, 'M1', 3, 0, 0),
(2, 0, 'M2', 2, 0, 0),
(3, 0, 'M3', 4, 0, 0),
(4, 0, 'M4', 2, 0, 0);

-- --------------------------------------------------------



-- Déchargement des données de la table `teacher`
--

INSERT INTO `teacher` (`id_user`, `fname_user`, `lname_user`, `cin_user`, `adress_user`, `email_user`, `city_user`, `image_user`, `password`, `is_deleted`) VALUES
(1, 'Prof', 'T1', 'HJ809809', '', 'T1@gmail.com', 'Agadir', NULL, '$2y$10$2d51frd69efgy70qTmyYkuWQdazGeoc/Hj45ciZYUELjyIzxXQDkC', 0),
(2, 'Prof', 'T2', 'F43434354', '', 'T2@gmail.com', 'Agadir', NULL, '$2y$10$mmG8/pMqmn5AHg3qdfqT/OLrCIem/ZgBhjK037W1e2L4mcIbMAimK', 0);

-- --------------------------------------------------------
