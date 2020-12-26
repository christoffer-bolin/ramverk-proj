--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "userId" INTEGER PRIMARY KEY NOT NULL,
    "username" TEXT UNIQUE NOT NULL,
    "password" TEXT NOT NULL,
    "email" TEXT
);

--
-- Table Forum
--
DROP TABLE IF EXISTS Forum;
CREATE TABLE Forum (
    "questionId" INTEGER PRIMARY KEY NOT NULL,
    "rubrik" TEXT NOT NULL,
    "question" TEXT NOT NULL,
    "userId" INTEGER NOT NULL
);

--
-- Table Answers
--
DROP TABLE IF EXISTS Answers;
CREATE TABLE Answers (
    "answerId" INTEGER PRIMARY KEY NOT NULL,
    "answer" TEXT NOT NULL,
    "questionId" INTEGER NOT NULL,
    "userId" INTEGER  NOT NULL
);

--
-- Table Tags
--
DROP TABLE IF EXISTS Tags;
CREATE TABLE Tags (
    "tagId" INTEGER PRIMARY KEY NOT NULL,
    "tag" TEXT UNIQUE NOT NULL
);


--
-- Table Comment
--
DROP TABLE IF EXISTS Comments;
CREATE TABLE Comments (
    "commentId" INTEGER PRIMARY KEY NOT NULL,
    "entryId" INTEGER,
    "userId" INTEGER,
    "answerId" INTEGER,
    "comment" TEXT
);



--
-- TABLE TagsPost
--
DROP TABLE IF EXISTS Tag2Forum;
CREATE TABLE Tag2Forum (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "tagId" INTEGER,
    "questionId" INTEGER,
    FOREIGN KEY("tagId") REFERENCES Tags("tagId"),
    FOREIGN KEY("questionId") REFERENCES Forum("questionId")
);
