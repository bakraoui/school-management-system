--
-- Déchargement des données de la table `branch`
--

INSERT INTO `branch` (`id_branch`, `title_branch`, `description_branch`, `is_deleted`) VALUES
(1, 'INFO', '<p>DD</p>', 0),
(2, 'BTP', '<p>DD</p>', 0);
-- --------------------------------------------------------

--

--
-- Déchargement des données de la table `class`
--

INSERT INTO `class` (`id_class`, `title_class`, `id_branch`, `is_deleted`) VALUES
(1, 'INFO1', 1, 0),
(2, 'INFO2', 1, 0),
(3, 'BTP1', 2, 0),
(4, 'BTP2', 2, 0);

-- --------------------------------------------------------

--

--
-- Déchargement des données de la table `classroom`
--

INSERT INTO `classroom` (`id_classroom`, `title_classroom`, `is_deleted`) VALUES
(1, 'S1', 0),
(2, 'S2', 0);




-- --------------------------------------------------------


--
-- Déchargement des données de la table `module`
--

INSERT INTO `module` (`id_module`, `title`, `is_deleted`) VALUES
(1, 'M1', 0),
(2, 'M2', 0),
( 3, 'M3', 0),
(4, 'M4', 0) ,
( 5, 'M5', 0),
( 6, 'M6', 0),
( 7, 'M7', 0),
( 8, 'M8', 0);

-- --------------------------------------------------------


--
-- Déchargement des données de la table `school`
--

INSERT INTO `school` (`id_school`, `name`, `adress`, `city`, `logo`, `type`, `email`, `tele`, `facebook`, `linked`, `insta`, `twitter`, `director`, `about`, `low`) VALUES
(1, 'Eddoha', 'El Houda', 'Agadir', NULL, 3, 'eddoha@gmail.com', '0666666600', NULL, NULL, NULL, NULL, '<p>director word</p>', '<p>About us text</p>', '<p>internal loww</p>');

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

-- --------------------------------------------------------


--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id_user`, `fname_user`, `lname_user`, `email_user`, `cin_user`, `cne_student`, `adress_user`, `city_user`, `image_user`, `password`, `is_deleted`) VALUES
(1, 'ETD', 'ETD1', 'E1@gmail.com', 'F23452435', 'FD2435432', '', '', NULL, '$2y$10$/vgPr6j23/flEpiyxozYieZr.37Xw53MlLfgw6RMamUG5CxnczUhe', 0),
(2, 'ETD', 'ETD2', 'E2@gmail.com', 'DS32432', 'SF345324543', '', '', NULL, '$2y$10$Nk9.Fu1bLe2/bTIw.bJXLu2m7mZAkYpdzivnEyIedGF.EzQ7Med5a', 0),
(3, 'ETD', 'ETD3', 'E3@gmail.com', 'G3232432433', 'TY5674654', '', '', NULL, '$2y$10$o23BFRzqZJkGmN8/Blpnne1Bvuj3P70q.NfG2iEVSegxhdNjZBAl6', 0),
(4, 'ETD', 'ETD4', 'E4@gmail.com', 'G3232432434', 'FD24354324', '', '', NULL, '$2y$10$uUFmLAHlBZLIDBWpq/ODyeB1xnVIXx7P/DoWziKS.uS3oNVoGgF4S', 0),
(5, 'ETD', 'ETD5', 'E5@gmail.com', 'F23452435G', 'FD24354324Z', '', '', NULL, '$2y$10$mOC6/G8HDgKAIIqMOTcs..QLQU04RA3xbKD3FTBRdD6DSQb/ObUxa', 0),
(6, 'ETD', 'ETD6', 'E6@gmail.com', 'HJ80980973', 'TY567465S', '', '', NULL, '$2y$10$oeUQIzxiFacW1gF/HZqQJetjx3hCDCH4SNtwG0ZLmW7dzLNCdfcgm', 0),
(7, 'ETD', 'ETD7', 'E7@gmail.com', 'SDQZ4343', 'SQDFQESF4532A', '', '', NULL, '$2y$10$viY9Otrc9gemd01c979JduRUo3Z42C4bN5y6gkpFuPwUvK1n5wxQe', 0),
(8, 'ETD', 'ETD8', 'E8@gmail.com', 'SDF234R5', 'ESRGTSER', '', '', NULL, '$2y$10$feKBFPXs5xgIUIW46R8QC.WSKeNO9XqpQSwNEXMp4vhooz2X/9Tku', 0);

-- --------------------------------------------------------

--
-- Structure de la table `subject`

-- Déchargement des données de la table `subject`
--

INSERT INTO `subject` (`id_subject`, `id_module`, `title_subject`, `coefficient`, `percentage`, `is_deleted`) VALUES
(1, 1, 'SUB1', 0, 0.4, 0),
(2, 1, 'SUB2', 0, 0.6, 0),
(3, 2, 'SUB3', 0, 1, 0),
(4, 3, 'SUB4', 0, 1, 0),
(5, 4, 'SUB5', 0, 1, 0),
(6, 5, 'SUB6', 0, 1, 0),
(7, 6, 'SUB7', 0, 1, 0),
(8, 7, 'SUB8', 0, 1, 0) ,
(9, 8, 'SUB9', 0, 1, 0);

-- --------------------------------------------------------


-- Déchargement des données de la table `teacher`
--

INSERT INTO `teacher` (`id_user`, `fname_user`, `lname_user`, `cin_user`, `adress_user`, `email_user`, `city_user`, `image_user`, `password`, `is_deleted`) VALUES
(1, 'Prof', 'T1', 'F43434354', '', 'T1@gmail.com', 'Agadir', NULL, '$2y$10$qKGA7SFtH3yaxkim5CXPHe0BR/IUcDyhnenq7I0swgc3G4YphYwwm', 0),
(2, 'Prof', 'T2', 'G323243243', '', 'T2@gmail.com', 'Agadir', NULL, '$2y$10$ymOUXNYQXI0RSWPuPUz6.eG58/t3i/TcewjZjoIrOKp9HWfIEW2dC', 0);

-- --------------------------------------------------------

