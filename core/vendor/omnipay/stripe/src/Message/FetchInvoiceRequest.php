on.forward:
        double scrollOffsetToChild = 0.0;
        RenderSliver? current = center;
        while (current != child) {
          scrollOffsetToChild += current!.geometry!.scrollExtent;
          current = childAfter(current);
        }
        return scrollOffsetToChild + scrollOffsetWithinChild;
      case GrowthDirection.reverse:
        double scrollOffsetToChild = 0.0;
        RenderSliver? current = childBefore(center!);
        while (current != child) {
          scrollOffsetToChild -= current!.geometry!.scrollExtent;
          current = childBefore(current);
        }
        return scrollOffsetToChild - scrollOffsetWithinChild;
    }
  }

  @override
  double maxScrollObstructionExtentBefore(RenderSliver child) {
    assert(child.parent == this);
    final GrowthDirection growthDirection = child.constraints.growthDirection;
    switch (growthDirection) {
      case GrowthDirection.forward:
        double pinnedExtent = 0.0;
        RenderSlive