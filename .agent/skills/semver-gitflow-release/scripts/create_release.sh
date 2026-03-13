#!/usr/bin/env bash
# Helper script to automate part of a SemVer GitFlow release.

set -e

NEW_VERSION="$1"
BUMP_TYPE="$2" # major|minor|patch (informational)

if [ -z "$NEW_VERSION" ]; then
  echo "Usage: create_release.sh NEW_VERSION [major|minor|patch]"
  exit 1
fi

echo "Starting release for version ${NEW_VERSION} (type: ${BUMP_TYPE})"

# Basic checks
if [ -n "$(git status --porcelain)" ]; then
  echo "Working tree is not clean. Commit or stash changes first."
  exit 1
fi

# Start GitFlow release
git flow release start "v${NEW_VERSION}"

# Example: here you would run a version bump tool or sed.
# NOTE: The agent should still reason about the proper files to edit.
# This script is just a scaffold.

echo "Remember to:"
echo "- Update plugin/theme version headers to ${NEW_VERSION}"
echo "- Update CHANGELOG.md"
echo "When done, run:"
echo "git flow release finish v${NEW_VERSION}"
echo "git push origin develop"
echo "git push origin main --tags"
